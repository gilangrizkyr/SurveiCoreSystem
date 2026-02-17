<?php

namespace App\Services;

use App\Repositories\Interfaces\ResponseRepositoryInterface;
use App\Models\SurveyResponse;
use App\Models\ResponseAnswer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResponseService
{
    protected ResponseRepositoryInterface $responseRepository;

    public function __construct(ResponseRepositoryInterface $responseRepository)
    {
        $this->responseRepository = $responseRepository;
    }

    public function submitResponse(int $surveyId, array $data, array $answers): SurveyResponse
    {
        return DB::transaction(function () use ($surveyId, $data, $answers) {
            $data['survey_id'] = $surveyId;
            $data['uuid'] = (string)Str::uuid();
            $data['status'] = 'completed';
            $data['submitted_at'] = now();

            /** @var SurveyResponse $response */
            $response = $this->responseRepository->create($data);

            foreach ($answers as $answer) {
                ResponseAnswer::create([
                    'response_id' => $response->id,
                    'question_id' => $answer['question_id'],
                    'option_id' => $answer['option_id'] ?? null,
                    'answer_text' => $answer['answer_text'] ?? null,
                    'answer_numeric' => $answer['answer_numeric'] ?? null,
                    'answer_date' => $answer['answer_date'] ?? null,
                ]);
            }

            return $response;
        });
    }

    public function getSurveyResponses(int $surveyId)
    {
        return $this->responseRepository->getResponsesBySurvey($surveyId);
    }
}