<?php

namespace App\Observers;

use App\Models\SurveyResponse;

class SurveyResponseObserver
{
    public function created(\App\Models\SurveyResponse $surveyResponse): void
    {
        // 1. Log Audit
        \App\Models\AuditLog::create([
            'action' => 'created',
            'model_type' => get_class($surveyResponse),
            'model_id' => $surveyResponse->id,
            'new_values' => $surveyResponse->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // 2. Trigger Webhooks
        $this->triggerWebhooks($surveyResponse, 'response.submitted');
    }

    protected function triggerWebhooks(\App\Models\SurveyResponse $response, string $event): void
    {
        $webhooks = \App\Models\Webhook::where('is_active', true)
            ->whereJsonContains('events', $event)
            ->get();

        foreach ($webhooks as $webhook) {
            // Ideally use a Job here, but for now simple dispatch
            dispatch(function () use ($webhook, $response, $event) {
                try {
                    \Illuminate\Support\Facades\Http::timeout(10)
                        ->withHeaders([
                            'X-Webhook-Secret' => $webhook->secret,
                            'X-Webhook-Event' => $event,
                        ])
                        ->post($webhook->url, [
                            'event' => $event,
                            'data' => [
                                'response_uuid' => $response->uuid,
                                'survey_title' => $response->survey->title,
                                'submitted_at' => $response->submitted_at,
                                'answers' => $response->answers->map(fn($a) => [
                                    'question' => $a->question->title,
                                    'answer' => $a->answer_text ?? $a->option?->label,
                                ]),
                            ],
                            'timestamp' => now()->toIso8601String(),
                        ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Webhook failed: " . $e->getMessage());
                }
            })->afterResponse();
        }
    }

    /**
     * Handle the SurveyResponse "updated" event.
     */
    public function updated(SurveyResponse $surveyResponse): void
    {
        //
    }

    /**
     * Handle the SurveyResponse "deleted" event.
     */
    public function deleted(SurveyResponse $surveyResponse): void
    {
        //
    }

    /**
     * Handle the SurveyResponse "restored" event.
     */
    public function restored(SurveyResponse $surveyResponse): void
    {
        //
    }

    /**
     * Handle the SurveyResponse "force deleted" event.
     */
    public function forceDeleted(SurveyResponse $surveyResponse): void
    {
        //
    }
}