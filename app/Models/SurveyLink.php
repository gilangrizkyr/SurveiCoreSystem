<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_id',
        'token',
        'max_responses',
        'expires_at',
        'used_count',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function distribution()
    {
        return $this->belongsTo(SurveyDistribution::class , 'distribution_id');
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class , 'link_id');
    }
}