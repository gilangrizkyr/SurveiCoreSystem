<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiSentimentAnalysis extends Model
{
    use HasFactory;

    protected $table = 'ai_sentiment_analysis';

    protected $fillable = [
        'response_id',
        'question_id',
        'answer_id',
        'text_content',
        'sentiment',
        'confidence_score',
        'emotion',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class , 'response_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(ResponseAnswer::class , 'answer_id');
    }
}