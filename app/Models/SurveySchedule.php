<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'starts_at',
        'ends_at',
        'timezone',
        'recurrence',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'recurrence' => 'json',
        'is_active' => 'boolean',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}