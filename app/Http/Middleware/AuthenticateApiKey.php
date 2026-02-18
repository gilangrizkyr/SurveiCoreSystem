<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
use App\Models\ApiUsageLog;
use Carbon\Carbon;

class AuthenticateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key is required. Include it in X-API-Key header or api_key query parameter.',
                'error' => 'MISSING_API_KEY'
            ], 401);
        }

        // Find API Key
        $key = ApiKey::where('key', $apiKey)
            ->whereNull('revoked_at')
            ->with('client')
            ->first();

        if (!$key) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Key',
                'error' => 'INVALID_API_KEY'
            ], 401);
        }

        // Check if expired
        if ($key->expires_at && Carbon::parse($key->expires_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'API Key has expired',
                'error' => 'EXPIRED_API_KEY'
            ], 401);
        }

        // Check IP Whitelist
        if ($key->ip_whitelist && count($key->ip_whitelist) > 0) {
            $clientIp = $request->ip();
            if (!in_array($clientIp, $key->ip_whitelist)) {
                return response()->json([
                    'success' => false,
                    'message' => 'IP address not whitelisted',
                    'error' => 'IP_NOT_WHITELISTED'
                ], 403);
            }
        }

        // Check rate limit (simplified - you might want to use Laravel's rate limiter)
        if ($key->rate_limit) {
            $lastHour = Carbon::now()->subHour();
            $usageCount = ApiUsageLog::where('api_key_id', $key->id)
                ->where('created_at', '>=', $lastHour)
                ->count();

            if ($usageCount >= $key->rate_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rate limit exceeded',
                    'error' => 'RATE_LIMIT_EXCEEDED',
                    'retry_after' => 3600 // seconds
                ], 429);
            }
        }

        // Update last used
        $key->update(['last_used_at' => now()]);

        // Log API usage
        ApiUsageLog::create([
            'api_key_id' => $key->id,
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $request->except(['password', 'secret']),
            'response_code' => null, // Will be updated in response
        ]);

        // Attach API key info to request
        $request->merge([
            'api_key_id' => $key->id,
            'api_client_id' => $key->client_id,
            'api_client' => $key->client,
        ]);

        return $next($request);
    }
}