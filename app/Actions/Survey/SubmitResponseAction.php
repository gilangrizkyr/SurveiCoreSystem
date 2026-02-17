<?php

namespace App\Actions\Survey;

use App\DTOs\Survey\SubmitResponseDTO;
use App\Models\SurveyResponse;
use App\Models\ResponseAnswer;
use App\Events\SurveyResponseSubmitted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmitResponseAction
{
    public function execute(SubmitResponseDTO $data): SurveyResponse
    {
        return DB::transaction(function () use ($data) {
            $response = SurveyResponse::create([
                'uuid' => (string)Str::uuid(),
                'survey_id' => $data->survey_id,
                'respondent_id' => $data->respondent_id,
                'link_id' => $data->link_id,
                'status' => 'completed',
                'started_at' => now()->subMinutes(5), // Simplified
                'submitted_at' => now(),
                'ip_address' => $data->ip_address,
                'user_agent' => $data->user_agent,
                'device_type' => $data->device_type,
                'geo_location' => $data->geo_location,
            ]);

            foreach ($data->answers as $answer) {
                ResponseAnswer::create([
                    'response_id' => $response->id,
                    'question_id' => $answer['question_id'],
                    'option_id' => $answer['option_id'] ?? null,
                    'answer_text' => $answer['answer_text'] ?? null,
                    'answer_numeric' => $answer['answer_numeric'] ?? null,
                    'answer_date' => $answer['answer_date'] ?? null,
                ]);
            }

            // Fire event for webhooks, analytics, etc.
            event(new SurveyResponseSubmitted($response));

            return $response;
        });
    }
}