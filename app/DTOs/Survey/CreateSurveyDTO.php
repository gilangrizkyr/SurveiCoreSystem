<?php

namespace App\DTOs\Survey;

class CreateSurveyDTO
{
    public function __construct(
        public string $title,
        public int $tenant_id,
        public int $creator_id,
        public ?string $description = null,
        public string $status = 'draft',
        public string $type = 'public',
        public ?string $welcome_message = null,
        public ?string $thank_you_message = null,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            title: $validated['title'],
            tenant_id: $validated['tenant_id'],
            creator_id: $validated['creator_id'],
            description: $validated['description'] ?? null,
            status: $validated['status'] ?? 'draft',
            type: $validated['type'] ?? 'public',
            welcome_message: $validated['welcome_message'] ?? null,
            thank_you_message: $validated['thank_you_message'] ?? null,
        );
    }
}