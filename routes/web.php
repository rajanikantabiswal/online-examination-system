<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EnrollmentController;

Route::get('/register', [AuthController::class, 'loadRegister']);
Route::post('/register', [AuthController::class, 'studentRegister'])->name('studentRegister');

Route::get('/login', function () {
    return redirect('/');
});

Route::get('/', [AuthController::class, 'loadLogin']);
Route::post('/login', [AuthController::class, 'userLogin'])->name('userLogin');

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/forgot-password', [AuthController::class, 'loadForgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/reset-password', [AuthController::class, 'loadResetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

// Route::get('/dashboard', [AuthController::class, 'studentDashboard'])->middleware('checkStudent');
// Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->middleware('checkAdmin');

Route::middleware(['checkStudent'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'studentDashboard']);
    Route::get('/exam/{exId?}', [CandidateController::class, 'examView'])->name('examView');
    Route::post('/exam-submit', [CandidateController::class, 'examSubmit'])->name('examSubmit');
    Route::post('/save-attempt', [CandidateController::class, 'saveAttempt'])->name('saveAttempt');
    Route::post('/fetch-attempt', [CandidateController::class, 'fetchAttempt'])->name('fetchAttempt');
    Route::post('/save-remaining-time', [CandidateController::class, 'saveRemainingTime'])->name('saveRemainingTime');
    
    Route::get('/thankyou/{examId?}', [CandidateController::class, 'thankYou'])->name('thankYou');
    Route::get('/result-dashboard/{attempt_id?}', [CandidateController::class, 'resultDashboard'])->name('resultDashboard');
    Route::post('/check-exam-attempt', [CandidateController::class, 'checkExamAttempt'])->name('check.exam.attempt');

    Route::get('/exam-history', [CandidateController::class, 'examHistory'])->name('examHistory');
    Route::get('/retake-exam/{exam_id?}', [CandidateController::class, 'retakeExam'])->name('retakeExam');
});

Route::prefix('admin')->middleware(['checkAdmin'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'adminDashboard']);

    //subjects route
    Route::post('/add-subject', [AdminController::class, 'addSubject'])->name('addSubject');
    Route::post('/edit-subject', [AdminController::class, 'editSubject'])->name('editSubject');
    Route::post('/delete-subject', [AdminController::class, 'deleteSubject'])->name('deleteSubject');

    //exams route
    Route::get('/exams/{exId?}', [AdminController::class, 'handleExam'])->name('exams');
    
    // Route::get('/exams', [AdminController::class, 'examDashboard']);
    Route::post('/add-exam', [AdminController::class, 'addExam'])->name('addExam');
    Route::get('/get-exam-details/{id}', [AdminController::class, 'getExamDetails'])->name('getExamDetails');
    Route::post('/update-exam', [AdminController::class, 'updateExam'])->name('updateExam');
    Route::post('/delete-exam', [AdminController::class, 'deleteExam'])->name('deleteExam');
    Route::post('/toggle-exam-status', [AdminController::class, 'toggleExamStatus'])->name('toggleExamStatus');

    //Q&A routes
    Route::get('/qna', [AdminController::class, 'qnaDashboard']);
    Route::post('/add-qna', [AdminController::class, 'addQna'])->name('addQna');
    Route::post('/update-qna', [AdminController::class, 'updateQna'])->name('updateQna');
    Route::get('/delete-answer', [AdminController::class, 'deleteAnswer'])->name('deleteAnswer');
    Route::post('/delete-qna', [AdminController::class, 'deleteQna'])->name('deleteQna');
    Route::post('/import-qna', [AdminController::class, 'importQna'])->name('importQna');
    Route::get('/get-qna-details', [AdminController::class, 'getQnaDetails'])->name('getQnaDetails');

    // Candidates routes
    Route::get('/candidates', [AdminController::class, 'candidateDashboard']);
    Route::post('/add-candidate', [AdminController::class, 'addCandidate'])->name('addCandidate');
    Route::get('/get-candidate-details/{cId}', [AdminController::class, 'getCandidateDetails'])->name('getCandidateDetails');
    Route::post('/update-candidate', [AdminController::class, 'updateCandidate'])->name('updateCandidate');
    Route::post('/delete-candidate', [AdminController::class, 'deleteCandidate'])->name('deleteCandidate');
    Route::post('/import-candidate', [AdminController::class, 'importCandidate'])->name('importCandidate');

    //View Responses routes
    Route::get('/view-responses', [AdminController::class, 'responsesDashboard']);
    Route::get('/view-responses/exam/{examId}', [AdminController::class, 'getExamResponses'])->name('getExamResponses');
    Route::get('/view-responses/exam/user/{attemptId}', [AdminController::class, 'getUserResponses'])->name('getUserResponses');

    
    //Enrollment Route

    Route::get('/exams/{exId?}/enroll', [EnrollmentController::class, 'enrollStudents'])->name('exams.enrollStudents');
    Route::post('exams/enroll-candidates', [EnrollmentController::class, 'enrollCandidatesToExam'])->name('exams.enrollCandidatesToExam');


   
});
