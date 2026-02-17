<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'question_id',
        'option_id',
        'answer_text',
        'answer_numeric',
        'answer_date',
        'answer_file_id',
        'metadata',
    ];

    protected $casts = [
        'answer_numeric' => 'decimal:4',
        'answer_date' => 'date',
        'metadata' => 'json',
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class , 'response_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(QuestionOption::class , 'option_id');
    }
}