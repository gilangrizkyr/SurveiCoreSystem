<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\CreateApiKeyDTO;
use App\Models\ApiKey;
use Illuminate\Support\Str;

class CreateApiKeyAction
{
    public function execute(CreateApiKeyDTO $data): array
    {
        $key = Str::random(32);
        $secret = Str::random(64);

        $apiKey = ApiKey::create([
            'client_id' => $data->client_id,
            'key' => 'sk_live_' . $key,
            'secret' => $secret, // Note: In production, this should be hashed
            'name' => $data->name,
            'scopes' => $data->scopes,
            'ip_whitelist' => $data->ip_whitelist,
            'expires_at' => $data->expires_at,
        ]);

        return [
            'api_key' => $apiKey,
            'plain_secret' => $secret
        ];
    }
}