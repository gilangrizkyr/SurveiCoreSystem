<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->api_client;

        if (!$client) {
            // If not an API client (maybe a direct user), skip or use default limits
            return $next($request);
        }

        $tier = $client->tier ?? 'free';
        $limits = $this->getLimitsForTier($tier);

        // Hourly limit
        $hourlyKey = "rate_limit:hourly:{$client->id}";
        $hourlyCount = Redis::incr($hourlyKey);

        if ($hourlyCount === 1) {
            Redis::expire($hourlyKey, 3600);
        }

        if ($hourlyCount > $limits['hourly']) {
            return $this->rateLimitResponse($limits['hourly'], 'hour');
        }

        // Minute limit
        $minuteKey = "rate_limit:minute:{$client->id}";
        $minuteCount = Redis::incr($minuteKey);

        if ($minuteCount === 1) {
            Redis::expire($minuteKey, 60);
        }

        if ($minuteCount > $limits['minute']) {
            $retryAfter = Redis::ttl($minuteKey);
            return $this->rateLimitResponse($limits['minute'], 'minute', $retryAfter);
        }

        // Add rate limit headers to response
        $response = $next($request);

        $response->headers->set('X-RateLimit-Limit', $limits['hourly']);
        $response->headers->set('X-RateLimit-Remaining', (string)max(0, $limits['hourly'] - $hourlyCount));
        $response->headers->set('X-RateLimit-Reset', (string)(time() + Redis::ttl($hourlyKey)));

        return $response;
    }

    private function getLimitsForTier(string $tier): array
    {
        return match ($tier) {
                'free' => ['hourly' => 1000, 'minute' => 30],
                'basic' => ['hourly' => 5000, 'minute' => 100],
                'premium' => ['hourly' => 25000, 'minute' => 500],
                'enterprise' => ['hourly' => 100000, 'minute' => 2000],
                default => ['hourly' => 1000, 'minute' => 30],
            };
    }

    private function rateLimitResponse(int $limit, string $window, int $retryAfter = 60)
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'RATE_LIMIT_EXCEEDED',
                'message' => "Rate limit of {$limit} requests per {$window} exceeded. Try again in {$retryAfter} seconds.",
                'retry_after' => $retryAfter,
            ],
        ], 429)->header('Retry-After', (string)$retryAfter);
    }
}