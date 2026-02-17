<?php

namespace App\DTOs\Survey;

class SubmitResponseDTO
{
    public function __construct(
        public int $survey_id,
        public array $answers,
        public ?int $respondent_id = null,
        public ?int $link_id = null,
        public ?string $ip_address = null,
        public ?string $user_agent = null,
        public ?string $device_type = null,
        public ?array $geo_location = null,
    ) {}

    public static function fromRequest(int $surveyId, array $validated): self
    {
        return new self(
            survey_id: $surveyId,
            answers: $validated['answers'],
            respondent_id: $validated['respondent_id'] ?? null,
            link_id: $validated['link_id'] ?? null,
            ip_address: $validated['ip_address'] ?? null,
            user_agent: $validated['user_agent'] ?? null,
            device_type: $validated['device_type'] ?? null,
            geo_location: $validated['geo_location'] ?? null,
        );
    }
}