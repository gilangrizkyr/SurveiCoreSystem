<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseAnalytics extends Model
{
    use HasFactory;

    protected $table = 'response_analytics';

    protected $fillable = [
        'response_id',
        'sentiment_score',
        'keywords',
        'anomaly_score',
        'fraud_probability',
        'quality_metrics',
    ];

    protected $casts = [
        'keywords' => 'json',
        'quality_metrics' => 'json',
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class , 'response_id');
    }
}