<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class SubmitResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'respondent_id' => 'nullable|exists:users,id',
            'link_id' => 'nullable|exists:survey_links,id',
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.option_id' => 'nullable|exists:question_options,id',
            'answers.*.answer_text' => 'nullable|string',
            'answers.*.answer_numeric' => 'nullable|numeric',
            'answers.*.answer_date' => 'nullable|date',
        ];
    }
}