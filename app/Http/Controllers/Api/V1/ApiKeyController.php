<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateApiKeyRequest;
use App\Http\Resources\ApiKeyResource;
use App\Actions\Auth\CreateApiKeyAction;
use App\DTOs\Auth\CreateApiKeyDTO;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function index(Request $request)
    {
        // For simplicity using relationship directly here
        $keys = ApiKey::whereHas('client', function ($query) use ($request) {
            $query->where('tenant_id', $request->user()->current_tenant_id ?? 1); // Fallback for demo
        })->get();

        return ApiKeyResource::collection($keys);
    }

    public function store(CreateApiKeyRequest $request, CreateApiKeyAction $action)
    {
        $dto = CreateApiKeyDTO::fromRequest($request->validated());
        $result = $action->execute($dto);

        return (new ApiKeyResource($result['api_key']))
            ->additional([
            'success' => true,
            'data' => [
                'secret' => $result['plain_secret']
            ]
        ]);
    }

    public function destroy(ApiKey $apiKey)
    {
        $apiKey->update(['revoked_at' => now()]);
        return response()->json([
            'success' => true,
            'message' => 'API Key revoked successfully'
        ]);
    }
}