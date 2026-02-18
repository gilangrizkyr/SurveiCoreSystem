<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Survey API Controller
 * 
 * Handles API-only survey interactions (no UI).
 * For external applications that want to integrate surveys
 * but provide their own UI.
 */
class SurveyApiController extends Controller
{
    /**
     * Get survey structure (questions, options, validation rules)
     * 
     * @param string $uuid Survey UUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStructure($uuid)
    {
        $survey = Survey::where('uuid', $uuid)
            ->where('status', 'active')
            ->with([
            'sections' => function ($query) {
            $query->orderBy('order');
        },
            'sections.questions' => function ($query) {
            $query->orderBy('order');
        },
            'sections.questions.options' => function ($query) {
            $query->orderBy('order');
        }
        ])
            ->first();

        if (!$survey) {
            return response()->json([
                'success' => false,
                'message' => 'Survey not found or not active',
                'error' => 'SURVEY_NOT_FOUND'
            ], 404);
        }

        // Check if accessible via API
        if (!in_array($survey->type, ['public', 'api_only'])) {
            return response()->json([
                'success' => false,
                'message' => 'This survey is not accessible via API',
                'error' => 'SURVEY_NOT_API_ACCESSIBLE'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'uuid' => $survey->uuid,
                'title' => $survey->title,
                'description' => $survey->description,
                'type' => $survey->type,
                'welcome_message' => $survey->welcome_message,
                'thank_you_message' => $survey->thank_you_message,
                'settings' => $survey->settings,
                'sections' => $survey->sections->map(function ($section) {
            return [
                        'id' => $section->id,
                        'title' => $section->title,
                        'description' => $section->description,
                        'order' => $section->order,
                        'questions' => $section->questions->map(function ($question) {
                    return [
                                    'id' => $question->id,
                                    'type' => $question->type,
                                    'title' => $question->title,
                                    'description' => $question->description,
                                    'placeholder' => $question->placeholder,
                                    'help_text' => $question->help_text,
                                    'is_required' => $question->is_required,
                                    'order' => $question->order,
                                    'validation_rules' => $question->validation_rules,
                                    'options' => $question->options->map(function ($option) {
                            return [
                                                'id' => $option->id,
                                                'label' => $option->label,
                                                'value' => $option->value,
                                                'order' => $option->order,
                                            ];
                        }
                                    ),
                                    ];
                    }
                            ),
                            ];
                }),
            ]
        ]);
    }

    /**
     * Submit survey response via API
     * 
     * @param Request $request
     * @param string $uuid Survey UUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitResponse(Request $request, $uuid)
    {
        $survey = Survey::where('uuid', $uuid)
            ->where('status', 'active')
            ->with(['sections.questions'])
            ->first();

        if (!$survey) {
            return response()->json([
                'success' => false,
                'message' => 'Survey not found or not active',
                'error' => 'SURVEY_NOT_FOUND'
            ], 404);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.answer' => 'nullable',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate required questions
        $allQuestions = $survey->sections->flatMap->questions;
        $requiredQuestions = $allQuestions->where('is_required', true)->pluck('id')->toArray();
        $answeredQuestions = collect($request->input('answers'))->pluck('question_id')->toArray();

        $missingRequired = array_diff($requiredQuestions, $answeredQuestions);
        if (count($missingRequired) > 0) {
            $missingTitles = $allQuestions->whereIn('id', $missingRequired)->pluck('title');
            return response()->json([
                'success' => false,
                'message' => 'Required questions not answered',
                'error' => 'MISSING_REQUIRED_QUESTIONS',
                'missing_questions' => $missingTitles
            ], 422);
        }

        // Create response
        $surveyResponse = SurveyResponse::create([
            'uuid' => (string)Str::uuid(),
            'survey_id' => $survey->id,
            'status' => 'completed',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => array_merge(
            $request->input('metadata', []),
            [
                'api_client_id' => $request->input('api_client_id'),
                'source' => 'api'
            ]
        ),
            'submitted_at' => now(),
        ]);

        // Save answers
        foreach ($request->input('answers') as $answerData) {
            $question = $allQuestions->firstWhere('id', $answerData['question_id']);

            if (!$question) {
                continue;
            }

            $answer = $answerData['answer'] ?? null;

            ResponseAnswer::create([
                'response_id' => $surveyResponse->id,
                'question_id' => $question->id,
                'answer_text' => is_string($answer) && !is_numeric($answer) ? $answer : null,
                'answer_number' => is_numeric($answer) ? $answer : null,
                'option_id' => (in_array($question->type, ['multiple_choice', 'dropdown']) && is_numeric($answer)) ? $answer : null,
                'answer_json' => (is_array($answer) || $question->type === 'checkboxes') ? json_encode($answer) : null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Response submitted successfully',
            'data' => [
                'response_uuid' => $surveyResponse->uuid,
                'survey_uuid' => $survey->uuid,
                'submitted_at' => $surveyResponse->submitted_at,
                'thank_you_message' => $survey->thank_you_message
            ]
        ], 201);
    }

    /**
     * Get survey statistics
     * 
     * @param string $uuid Survey UUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats($uuid)
    {
        $survey = Survey::where('uuid', $uuid)->first();

        if (!$survey) {
            return response()->json([
                'success' => false,
                'message' => 'Survey not found',
                'error' => 'SURVEY_NOT_FOUND'
            ], 404);
        }

        $totalResponses = SurveyResponse::where('survey_id', $survey->id)->count();
        $completedResponses = SurveyResponse::where('survey_id', $survey->id)
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'uuid' => $survey->uuid,
                'title' => $survey->title,
                'status' => $survey->status,
                'total_responses' => $totalResponses,
                'completed_responses' => $completedResponses,
                'created_at' => $survey->created_at,
                'starts_at' => $survey->starts_at,
                'ends_at' => $survey->ends_at,
            ]
        ]);
    }
}