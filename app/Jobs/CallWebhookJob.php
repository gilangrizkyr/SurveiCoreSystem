<?php

namespace App\Jobs;

use App\Models\Webhook;
use App\Models\WebhookLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CallWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Webhook $webhook,
        public string $event,
        public array $payload
        )
    {
    }

    public function handle(): void
    {
        $startTime = microtime(true);
        $attempt = 1;
        $success = false;

        try {
            $response = Http::withHeaders([
                'X-Survey-Event' => $this->event,
                'X-Survey-Signature' => $this->generateSignature($this->payload, $this->webhook->secret),
            ])
                ->timeout($this->webhook->timeout_seconds ?? 30)
                ->post($this->webhook->url, $this->payload);

            $success = $response->successful();

            WebhookLog::create([
                'webhook_id' => $this->webhook->id,
                'event' => $this->event,
                'payload' => json_encode($this->payload),
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'attempt_number' => $attempt,
                'delivered_at' => $success ? now() : null,
                'failed_at' => $success ? null : now(),
            ]);

        }
        catch (\Exception $e) {
            WebhookLog::create([
                'webhook_id' => $this->webhook->id,
                'event' => $this->event,
                'payload' => json_encode($this->payload),
                'status_code' => 500,
                'response_body' => $e->getMessage(),
                'attempt_number' => $attempt,
                'failed_at' => now(),
            ]);
        }
    }

    protected function generateSignature(array $payload, string $secret): string
    {
        return hash_hmac('sha256', json_encode($payload), $secret);
    }
}