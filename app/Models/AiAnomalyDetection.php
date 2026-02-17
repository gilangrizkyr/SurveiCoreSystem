<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnomalyDetection extends Model
{
    use HasFactory;

    protected $table = 'ai_anomaly_detection';

    protected $fillable = [
        'response_id',
        'anomaly_type',
        'severity',
        'description',
        'confidence_score',
        'auto_flagged',
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class , 'response_id');
    }
}