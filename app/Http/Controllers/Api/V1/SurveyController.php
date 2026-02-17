<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\CreateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Actions\Survey\CreateSurveyAction;
use App\DTOs\Survey\CreateSurveyDTO;
use App\Services\SurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    private SurveyService $surveyService;

    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function index()
    {
        $surveys = $this->surveyService->getAllSurveys();
        return SurveyResource::collection($surveys);
    }

    public function store(CreateSurveyRequest $request, CreateSurveyAction $action)
    {
        $validated = $request->validated();
        $validated['creator_id'] = Auth::id();

        $dto = CreateSurveyDTO::fromRequest($validated);
        $survey = $action->execute($dto);

        return response()->json([
            'success' => true,
            'message' => 'Survey created successfully',
            'data' => new SurveyResource($survey)
        ], 201);
    }

    public function show($uuid)
    {
        $survey = $this->surveyService->getSurveyWithDetails($uuid);
        if (!$survey) {
            return response()->json([
                'success' => false,
                'message' => 'Survey not found'
            ], 404);
        }
        return new SurveyResource($survey);
    }

    public function update(Request $request, $uuid)
    {
        // For simplicity using array here, but ideally update should also use DTO/Action
        $survey = $this->surveyService->getSurveyWithDetails($uuid);
        if (!$survey) {
            return response()->json(['success' => false, 'message' => 'Survey not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:500',
            'description' => 'nullable|string',
            'status' => 'in:draft,active,paused,closed,archived',
        ]);

        if ($this->surveyService->updateSurvey($survey->id, $validated)) {
            return response()->json([
                'success' => true,
                'message' => 'Updated successfully'
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Failed to update'], 400);
    }

    public function destroy($uuid)
    {
        $survey = $this->surveyService->getSurveyWithDetails($uuid);
        if (!$survey) {
            return response()->json(['success' => false, 'message' => 'Survey not found'], 404);
        }

        if ($this->surveyService->deleteSurvey($survey->id)) {
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully'
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Failed to delete'], 400);
    }
}