<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'max_responses',
        'current_count',
        'demographic_limits',
    ];

    protected $casts = [
        'demographic_limits' => 'json',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}