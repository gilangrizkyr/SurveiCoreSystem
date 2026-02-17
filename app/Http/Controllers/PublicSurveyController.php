<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicSurveyController extends Controller
{
    public function show($uuid)
    {
        $survey = \App\Models\Survey::query()
            ->where('uuid', '=', $uuid)
            ->where('status', '=', 'active')
            ->with(['sections.questions.options'])
            ->firstOrFail();

        return view('public.survey.show', compact('survey'));
    }

    public function store(Request $request, $uuid)
    {
        $survey = \App\Models\Survey::query()
            ->where('uuid', '=', $uuid)
            ->firstOrFail();

        $response = \App\Models\SurveyResponse::create([
            'uuid' => (string)\Illuminate\Support\Str::uuid(),
            'survey_id' => $survey->id,
            'status' => 'completed',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'submitted_at' => now(),
        ]);

        foreach ($request->input('answers', []) as $questionId => $answer) {
            \App\Models\ResponseAnswer::create([
                'response_id' => $response->id,
                'question_id' => $questionId,
                'answer_text' => is_string($answer) && !is_numeric($answer) ? $answer : null,
                'option_id' => is_numeric($answer) ? $answer : null,
            ]);
        }

        return back()->with('success', 'Terima kasih! Jawaban Anda telah kami terima.');
    }
}