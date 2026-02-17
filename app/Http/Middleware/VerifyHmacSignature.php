<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class VerifyHmacSignature
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');
        $timestamp = $request->header('X-Timestamp');
        $nonce = $request->header('X-Nonce');
        $signature = $request->header('X-Signature');

        if (!$apiKey || !$timestamp || !$nonce || !$signature) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'MISSING_SIGNATURE_HEADERS',
                    'message' => 'Required signature headers are missing',
                ],
            ], 401);
        }

        // Validate timestamp (±5 minutes)
        if (abs(time() - (int)$timestamp) > 300) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'TIMESTAMP_EXPIRED',
                    'message' => 'Request timestamp is outside the allowed window',
                ],
            ], 401);
        }

        // Check nonce (prevent replay attacks)
        $nonceKey = "nonce:{$nonce}";
        if (Redis::exists($nonceKey)) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'NONCE_REUSED',
                    'message' => 'This nonce has already been used',
                ],
            ], 401);
        }

        // Store nonce with 10-minute expiry
        Redis::setex($nonceKey, 600, '1');

        // Find API key
        $apiKeyModel = ApiKey::where('key', $apiKey)
            ->whereNull('revoked_at')
            ->where(function ($query) {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })
            ->first();

        if (!$apiKeyModel) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'INVALID_API_KEY',
                    'message' => 'The provided API key is invalid or expired',
                ],
            ], 401);
        }

        // Verify signature
        $computedSignature = $this->generateSignature(
            $request->method(),
            $request->path(),
            $request->getQueryString() ?? '',
            (int)$timestamp,
            $nonce,
            $request->getContent(),
            $apiKeyModel->secret
        );

        if (!hash_equals($computedSignature, $signature)) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'SIGNATURE_INVALID',
                    'message' => 'The request signature is invalid',
                ],
            ], 401);
        }

        // Attach API client to request for downstream use
        $request->merge(['api_client' => $apiKeyModel->client]);

        return $next($request);
    }

    private function generateSignature(
        string $method,
        string $path,
        string $query,
        int $timestamp,
        string $nonce,
        string $body,
        string $secret
        ): string
    {
        $bodyHash = hash('sha256', $body);
        $message = implode("\n", [$method, $path, $query, $timestamp, $nonce, $bodyHash]);

        return hash_hmac('sha256', $message, $secret);
    }
}