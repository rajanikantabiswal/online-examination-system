<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [

        'exam_name',
        'time',
        'exam_passkey',
        'mark_per_que',
        'passing_criteria',
        'is_active',
        'retake',
        'view_result'
    ];

    public function questions(){
        return $this->hasMany(Question::class, 'exam_id', 'id');
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class, 'exam_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'exam_user', 'exam_id', 'user_id');
    }
    
}
