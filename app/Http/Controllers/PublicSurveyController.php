<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\ResponseAnswer;

class PublicSurveyController extends Controller
{
    public function show($uuid)
    {
        $survey = Survey::query()
            ->where('uuid', '=', $uuid)
            ->where('status', '=', 'active')
            ->with(['sections.questions.options'])
            ->firstOrFail();

        // Check if already submitted (duplicate prevention)
        $alreadySubmitted = $this->checkDuplicateSubmission($survey, request());

        return view('public.survey.show', compact('survey', 'alreadySubmitted'));
    }

    public function store(Request $request, $uuid)
    {
        $survey = Survey::query()
            ->where('uuid', '=', $uuid)
            ->with(['sections.questions']) // Eager load questions for type checking
            ->firstOrFail();

        // Validate respondent identity if required
        $rules = ['answers' => 'required|array'];

        if ($survey->require_respondent_identity) {
            $rules['respondent_name'] = 'required|string|max:255';
            $rules['respondent_email'] = 'required|email|max:255';
            $rules['respondent_phone'] = 'nullable|string|max:255';
            $rules['respondent_nik'] = 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

        // Check duplicate submission
        if (!$survey->allow_multiple_submissions) {
            if ($this->checkDuplicateSubmission($survey, $request)) {
                return back()->with('error', 'Anda sudah pernah mengisi survei ini sebelumnya.');
            }
        }

        // Generate session token and fingerprint
        $sessionToken = $this->getSessionToken($request);
        $fingerprint = $this->generateFingerprint($request);

        // Create response
        $response = SurveyResponse::create([
            'uuid' => (string)Str::uuid(),
            'survey_id' => $survey->id,
            'respondent_name' => $request->input('respondent_name'),
            'respondent_email' => $request->input('respondent_email'),
            'respondent_phone' => $request->input('respondent_phone'),
            'respondent_nik' => $request->input('respondent_nik'),
            'status' => 'completed',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_token' => $sessionToken,
            'fingerprint' => $fingerprint,
            'metadata' => [
                'source' => 'web',
            ],
            'submitted_at' => now(),
        ]);

        // Flatten questions for easy lookup
        $allQuestions = $survey->sections->pluck('questions')->flatten()->keyBy('id');

        // Save answers
        foreach ($request->input('answers', []) as $questionId => $answer) {
            // Handle different answer types
            $answerText = null;
            $answerNumber = null;
            $optionId = null;
            $answerJson = null;

            if (is_array($answer)) {
                // Checkboxes - multiple options
                $answerJson = json_encode($answer);
            }
            elseif (is_numeric($answer) && !is_string($answer)) {
                // Check question type
                $question = $allQuestions->get($questionId);

                if ($question && in_array($question->type, ['multiple_choice', 'dropdown', 'scale'])) {
                    $optionId = $answer;
                }
                else {
                    $answerNumber = $answer;
                }
            }
            else {
                // Text answer or Radio button value submitted as string
                // Check if it's an option ID submitted as string
                $question = $allQuestions->get($questionId);
                if ($question && in_array($question->type, ['multiple_choice', 'dropdown', 'scale']) && is_numeric($answer)) {
                    $optionId = (int)$answer;
                }
                else {
                    $answerText = $answer;
                }
            }

            ResponseAnswer::create([
                'response_id' => $response->id,
                'question_id' => $questionId,
                'answer_text' => $answerText,
                'answer_numeric' => $answerNumber,
                'option_id' => $optionId,
                'metadata' => is_array($answer) ? null : ['answer_json' => $answerJson],
            ]);
        }

        // Set cookie for duplicate prevention if method is cookie
        if (!$survey->allow_multiple_submissions && $survey->duplicate_prevention_method === 'cookie') {
            cookie()->queue(cookie()->forever('survey_' . $survey->id, 'submitted'));
        }

        return back()->with('success', 'Terima kasih! Jawaban Anda telah kami terima.');
    }

    /**
     * Check if user has already submitted this survey
     */
    private function checkDuplicateSubmission(Survey $survey, Request $request): bool
    {
        if ($survey->allow_multiple_submissions) {
            return false;
        }

        switch ($survey->duplicate_prevention_method) {
            case 'email':
                $email = $request->input('respondent_email');
                if ($email) {
                    return SurveyResponse::where('survey_id', $survey->id)
                        ->where('respondent_email', $email)
                        ->where('status', 'completed')
                        ->exists();
                }
                break;

            case 'cookie':
                // Check strict cookie first (Google Form style)
                if ($request->hasCookie('survey_' . $survey->id)) {
                    return true;
                }
                // Fallback: check session token if cookie exists (legacy/backup)
                $sessionToken = $request->cookie('session_token');
                if ($sessionToken) {
                    return SurveyResponse::where('survey_id', $survey->id)
                        ->where('session_token', $sessionToken)
                        ->where('status', 'completed')
                        ->exists();
                }
                break;

            case 'login':
                if (auth()->check()) {
                    return SurveyResponse::where('survey_id', $survey->id)
                        ->where('respondent_id', auth()->id())
                        ->where('status', 'completed')
                        ->exists();
                }
                break;
        }

        return false;
    }

    /**
     * Get or generate session token
     */
    private function getSessionToken(Request $request): string
    {
        $token = $request->cookie('session_token');
        if (!$token) {
            $token = Str::random(32);
            cookie()->queue('session_token', $token, 60 * 24 * 365);
        }
        return $token;
    }

    /**
     * Generate browser fingerprint
     */
    private function generateFingerprint(Request $request): string
    {
        $data = [
            $request->ip(),
            $request->userAgent(),
            $request->header('Accept-Language'),
        ];
        return hash('sha256', implode('|', $data));
    }
}