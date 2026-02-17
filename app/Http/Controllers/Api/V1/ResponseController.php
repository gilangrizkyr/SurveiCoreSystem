<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Survey\SubmitResponseRequest;
use App\Http\Resources\ResponseResource;
use App\Actions\Survey\SubmitResponseAction;
use App\DTOs\Survey\SubmitResponseDTO;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    protected ResponseService $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function store(SubmitResponseRequest $request, SubmitResponseAction $action, $surveyId)
    {
        $dto = SubmitResponseDTO::fromRequest((int)$surveyId, $request->validated());
        $response = $action->execute($dto);

        return response()->json([
            'success' => true,
            'message' => 'Response submitted successfully',
            'data' => new ResponseResource($response)
        ], 201);
    }

    public function index($surveyId)
    {
        $responses = $this->responseService->getSurveyResponses((int)$surveyId);
        return ResponseResource::collection($responses);
    }

    public function submit(SubmitResponseRequest $request, SubmitResponseAction $action, $surveyId)
    {
        return $this->store($request, $action, $surveyId);
    }
}