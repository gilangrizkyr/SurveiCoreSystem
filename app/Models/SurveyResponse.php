<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'survey_id',
        'respondent_id',
        'link_id',
        'respondent_name',
        'respondent_email',
        'respondent_phone',
        'respondent_nik',
        'status',
        'started_at',
        'submitted_at',
        'completion_time_seconds',
        'ip_address',
        'user_agent',
        'device_type',
        'geo_location',
        'quality_score',
        'is_flagged',
        'flag_reason',
        'metadata',
        'session_token',
        'fingerprint',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'geo_location' => 'json',
        'metadata' => 'json',
        'is_flagged' => 'boolean',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function respondent()
    {
        return $this->belongsTo(User::class , 'respondent_id');
    }

    public function answers()
    {
        return $this->hasMany(ResponseAnswer::class , 'response_id');
    }

    public function files()
    {
        return $this->hasMany(ResponseFile::class , 'response_id');
    }

    public function analytics()
    {
        return $this->hasOne(ResponseAnalytics::class , 'response_id');
    }
}