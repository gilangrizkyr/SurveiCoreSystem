<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiKeywordExtraction extends Model
{
    use HasFactory;

    protected $table = 'ai_keyword_extraction';

    protected $fillable = [
        'survey_id',
        'question_id',
        'keyword',
        'frequency',
        'relevance_score',
        'category',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}