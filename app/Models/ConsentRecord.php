<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsentRecord extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'survey_id',
        'response_id',
        'consent_type',
        'given',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'given' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class , 'response_id');
    }
}