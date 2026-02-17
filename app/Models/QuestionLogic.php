<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionLogic extends Model
{
    use HasFactory;

    protected $table = 'question_logic';

    protected $fillable = [
        'question_id',
        'condition_type',
        'source_question_id',
        'operator',
        'value',
        'target_question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function sourceQuestion()
    {
        return $this->belongsTo(Question::class , 'source_question_id');
    }

    public function targetQuestion()
    {
        return $this->belongsTo(Question::class , 'target_question_id');
    }
}