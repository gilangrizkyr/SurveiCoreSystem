<?php

namespace App\Listeners;

use App\Events\SurveyResponseSubmitted;
use App\Jobs\CallWebhookJob;
use App\Models\Webhook;

class ProcessWebhookTriggers
{
    public function handle(SurveyResponseSubmitted $event): void
    {
        $survey = $event->response->survey;

        // Find webhooks for this survey or tenant
        $webhooks = Webhook::where('is_active', true)
            ->where(function ($query) use ($survey) {
            $query->where('survey_id', $survey->id)
                ->orWhereNull('survey_id'); // Global tenant webhooks
        })
            ->where('tenant_id', $survey->tenant_id)
            ->get();

        foreach ($webhooks as $webhook) {
            if (in_array('response.submitted', $webhook->events)) {
                CallWebhookJob::dispatch($webhook, 'response.submitted', $event->response->toArray());
            }
        }
    }
}