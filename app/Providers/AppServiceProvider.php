<?php

namespace App\Providers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Gate::define('retake', function ($user, $examId) {
            $exam = Exam::find($examId);
            $totalAttempts = $exam->examAttempts()->where('user_id', $user->id)->count();
            return $exam && $exam->retake > $totalAttempts;
        });

        Gate::define('view-result', function ($user, $examId) {
            $exam = Exam::find($examId);
            return $exam && $exam->view_result == 1;
        });
    }
}
