<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable= [
        'exam_id',
        'user_id',
        'status',
        'marks',
        'full_mark',
        'remainingTime'
        
    ];
    use HasFactory;
    public function exams()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
