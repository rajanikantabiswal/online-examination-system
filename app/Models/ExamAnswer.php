<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    protected $fillable= [
        'attempt_id',
        'question_id',
        'answer_id'
    ];
    use HasFactory;
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
   
}
