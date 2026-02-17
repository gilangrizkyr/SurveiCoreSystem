<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IpWhitelist
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->api_client;

        if (!$client || !$client->ip_whitelist) {
            return $next($request);
        }

        $whitelist = $client->ip_whitelist;
        if (is_string($whitelist)) {
            $whitelist = json_decode($whitelist, true);
        }

        $requestIp = $request->ip();

        if (!in_array($requestIp, $whitelist)) {
            Log::warning("IP not whitelisted: {$requestIp} for client {$client->id}");

            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'IP_NOT_AUTHORIZED',
                    'message' => 'Your IP address is not authorized to access this API',
                ],
            ], 403);
        }
        return $next($request);
    }
}