<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'survey_id' => $this->survey_id,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at,
            'quality_score' => $this->quality_score,
            'answers' => $this->whenLoaded('answers'),
        ];
    }
}