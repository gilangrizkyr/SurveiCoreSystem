<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'total_views',
        'total_started',
        'total_completed',
        'completion_rate',
        'avg_completion_time',
        'drop_off_points',
        'device_breakdown',
        'location_breakdown',
        'last_calculated_at',
    ];

    protected $casts = [
        'drop_off_points' => 'array',
        'device_breakdown' => 'array',
        'location_breakdown' => 'array',
        'last_calculated_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}