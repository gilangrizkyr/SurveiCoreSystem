<?php

namespace App\DTOs\Auth;

class CreateApiKeyDTO
{
    public function __construct(
        public int $client_id,
        public string $name,
        public array $scopes = [],
        public array $ip_whitelist = [],
        public ?string $expires_at = null,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            client_id: $validated['client_id'],
            name: $validated['name'],
            scopes: $validated['scopes'] ?? [],
            ip_whitelist: $validated['ip_whitelist'] ?? [],
            expires_at: $validated['expires_at'] ?? null,
        );
    }
}