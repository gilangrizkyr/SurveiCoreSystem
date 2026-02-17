<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'insight_type',
        'title',
        'description',
        'data',
        'confidence_score',
        'generated_at',
    ];

    protected $casts = [
        'data' => 'json',
        'generated_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}