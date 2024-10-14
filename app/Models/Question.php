<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'exam_id'
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function answers(){
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
    
    public function examAnswers()
    {
        return $this->hasMany(ExamAnswer::class, 'question_id');
    }

    
}
