<?php

namespace App\Actions\Survey;

use App\DTOs\Survey\CreateSurveyDTO;
use App\Models\Survey;
use Illuminate\Support\Str;

class CreateSurveyAction
{
    public function execute(CreateSurveyDTO $data): Survey
    {
        return Survey::create([
            'uuid' => (string)Str::uuid(),
            'tenant_id' => $data->tenant_id,
            'creator_id' => $data->creator_id,
            'title' => $data->title,
            'description' => $data->description,
            'status' => $data->status,
            'type' => $data->type,
            'welcome_message' => $data->welcome_message,
            'thank_you_message' => $data->thank_you_message,
        ]);
    }
}