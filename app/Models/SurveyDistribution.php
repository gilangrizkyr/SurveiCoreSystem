<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'channel',
        'settings',
    ];

    protected $casts = [
        'settings' => 'json',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function links()
    {
        return $this->hasMany(WebhookLog::class  , 'distribution_id');
    }
}