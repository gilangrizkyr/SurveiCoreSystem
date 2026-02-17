<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:500',
            'description' => 'nullable|string',
            'tenant_id' => 'required|exists:tenants,id',
            'status' => 'sometimes|in:draft,active,paused,closed,archived',
            'type' => 'sometimes|in:public,private,embedded,api_only',
            'welcome_message' => 'nullable|string',
            'thank_you_message' => 'nullable|string',
        ];
    }
}