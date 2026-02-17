<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySection extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'title',
        'description',
        'order',
        'logic',
    ];

    protected $casts = [
        'logic' => 'json',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class , 'section_id');
    }
}