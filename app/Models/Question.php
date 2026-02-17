<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'type',
        'title',
        'description',
        'placeholder',
        'help_text',
        'is_required',
        'order',
        'validation_rules',
        'logic_rules',
        'metadata',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'validation_rules' => 'json',
        'logic_rules' => 'json',
        'metadata' => 'json',
    ];

    public function section()
    {
        return $this->belongsTo(SurveySection::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function answers()
    {
        return $this->hasMany(ResponseAnswer::class);
    }
}