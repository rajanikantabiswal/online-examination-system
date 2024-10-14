<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CandidateController extends Controller
{
   public function examView($exam_passkey)
   {
      $exam_id = Exam::where('exam_passkey', $exam_passkey)->pluck('id')->first();
      $examAttempt = ExamAttempt::where('user_id', Auth::user()->id)->where('exam_id', $exam_id)->latest()->first();
      $exam = Exam::with(['questions.answers'])->where('is_active', 1)->findOrFail($exam_id);
      if ($examAttempt) {
         $examAnswerIds = ExamAnswer::where('attempt_id', $examAttempt->id)->pluck('answer_id')->toArray();
      } else {
         $examAnswerIds = [];
      }


      // if ($examAttempt) {
      //    return view('student.examv3', compact('examAttempt'));
      // } else {
      //    return view('student.examv3', compact('exam'));
      // }
      return view('student.examv3', compact(['exam', 'examAnswerIds']));
      //return $examAnswer;


      //return $exam;

   }

   // public function examSubmit(Request $request)
   // {

   //    try {
   //       $now = Carbon::now();
   //       $attempt_id = ExamAttempt::insertGetId([
   //          'exam_id' => $request->exam_id,
   //          'user_id' => Auth::user()->id,
   //          'created_at' => $now,
   //          'updated_at' => $now
   //       ]);


   //       $qCount = count($request->q);
   //       if ($qCount > 0) {
   //          for ($i = 0; $i < $qCount; $i++) {
   //             ExamAnswer::create([
   //                'attempt_id' => $attempt_id,
   //                'question_id' => $request->q[$i],
   //                'answer_id' => request()->input('ans_' . $i + 1)
   //             ]);
   //          }
   //       }

   //       $examAnswers = ExamAnswer::with('question.answers')
   //          ->where('attempt_id', $attempt_id)
   //          ->get();

   //       $examDetails = Exam::where('id', $request->exam_id)->first();
   //       $fullMark = $examDetails->mark_per_que * $qCount;
   //       $marks = 0;
   //       foreach ($examAnswers as $examAnswer) {
   //          foreach ($examAnswer->question->answers as $answer) {
   //             $isCorrect = $answer->is_correct == 1;
   //             $isSelected = $examAnswer->answer_id == $answer->id;
   //             if ($isCorrect && $isSelected) {
   //                $marks = $marks + $examDetails->mark_per_que;
   //             }
   //          }
   //       }

   //       $percentage_secured = ($marks / $fullMark) * 100;
   //       $status = 0;
   //       if ($percentage_secured > $examDetails->passing_criteria) {
   //          $status = 1;
   //       }

   //       $updateMarks = ExamAttempt::where('id', $attempt_id)->first();
   //       $updateMarks->marks = $marks;
   //       $updateMarks->full_mark = $fullMark;
   //       $updateMarks->status = $status;
   //       $updateMarks->save();

   //       return response()->json(['success' => true, 'examId' => $request->exam_id]);
   //    } catch (\Exception $e) {
   //       return response()->json(['success' => false, 'msg' => $e->getMessage()]);
   //    }


   //    //return $mark_per_que;

   //    //   return view('student.thankyou')->with('attempt_id', $attempt_id);


   // }

   public function examSubmit(Request $request)
   {

      try {

         $examAttempt = ExamAttempt::find($request->attempt_id);
         $examAttempt->exam_status = "Submitted";
         $examAttempt->save();

         $examAnswers = ExamAnswer::with('question.answers')
            ->where('attempt_id', $examAttempt->id)
            ->get();

         $examDetails = Exam::where('id', $examAttempt->exam_id)->first();
         $totalQuestion = Question::where('exam_id', $examAttempt->exam_id)->count();
         $fullMark = $examDetails->mark_per_que * $totalQuestion;
         $marks = 0;
         foreach ($examAnswers as $examAnswer) {
            foreach ($examAnswer->question->answers as $answer) {
               $isCorrect = $answer->is_correct == 1;
               $isSelected = $examAnswer->answer_id == $answer->id;
               if ($isCorrect && $isSelected) {
                  $marks = $marks + $examDetails->mark_per_que;
               }
            }
         }

         $percentage_secured = ($marks / $fullMark) * 100;
         $status = 0;
         if ($percentage_secured > $examDetails->passing_criteria) {
            $status = 1;
         }

         $updateMarks = ExamAttempt::where('id', $examAttempt->id)->first();
         $updateMarks->marks = $marks;
         $updateMarks->full_mark = $fullMark;
         $updateMarks->status = $status;
         $updateMarks->save();


         return response()->json(['success' => true, 'examId' => $examAttempt->exam_id]);
      } catch (\Exception $e) {
         return response()->json(['success' => false, 'msg' => $e->getMessage()]);
      }


      //return $mark_per_que;

      //   return view('student.thankyou')->with('attempt_id', $attempt_id);


   }


   public function saveAttempt(Request $request)
   {
      // Validate the request
      $validated = $request->validate([
         'attempt_id' => 'required|integer',
         'question_id' => 'required|integer',
         'answer_id' => 'required|integer',
      ]);

      // Update or create attempt entry
      $attempt = ExamAnswer::updateOrCreate(
         [
            'attempt_id' => $request->attempt_id,
            'question_id' => $request->question_id,
         ],
         [
            'answer_id' => $request->answer_id,
         ]
      );

      return response()->json(['success' => true, 'message' => 'Answer saved successfully']);
   }

   public function fetchAttempt(Request $request)
   {
      // Validate the incoming request
      $validated = $request->validate([
         'user_id' => 'required|integer',
         'exam_id' => 'required|integer',
      ]);

      // Try to find an existing exam attempt
      $attempt = ExamAttempt::where('user_id', $request->user_id)
         ->where('exam_id', $request->exam_id)
         ->latest()
         ->first();
      $exam = Exam::findOrFail($request->exam_id);

      $examTime = $exam->time;
      if (!$attempt || $attempt->exam_status == "Submitted") {
         $attempt = ExamAttempt::create([
            'user_id' => $request->user_id,
            'exam_id' => $request->exam_id,
            'remainingTime' => $exam->time . ":00"
         ]);
      }

      if ($attempt && $attempt->exam_status == "pending" && !is_null($attempt->remainingTime)) {
         $examTime = $attempt->remainingTime;
      }


      return response()->json([
         'success' => true,
         'attempt_id' => $attempt->id,
         'time' => $examTime
      ]);
   }

   public function saveRemainingTime(Request $request)
   {
      $examAttemptId = $request->input('exam_attempt_id');
      $remainingTime = $request->input('remainingTime');  // This will be in HH:MM or HH:MM:SS format

      $examAttempt = ExamAttempt::find($examAttemptId);

      if ($examAttempt) {
         // Save the remaining time
         $examAttempt->remainingTime = $remainingTime;  // Assuming remainingTime column stores the string format
         $examAttempt->save();

         return response()->json(['success' => 'Time saved successfully']);
      } else {
         return response()->json(['error' => 'Exam attempt not found'], 404);
      }
   }



   public function thankYou($examId)
   {
      return view('student.thankyou')->with('exam_id', $examId);
   }

   // public function resultDashboard($attempt_id)
   // {
   //    $examAnswers = ExamAnswer::with('question.answers')
   //       ->where('attempt_id', $attempt_id)
   //       ->get();
   //    $examAttempt = ExamAttempt::with(['user', 'exams'])->where('id', $attempt_id)->first();

   //    if (is_null($examAttempt)) {
   //       abort(404);
   //    }

   //    if ($examAttempt->user_id == Auth::user()->id) {
   //       return view('student.answers', compact('examAnswers', 'examAttempt'));
   //    } else {
   //       abort(404);
   //    }
   // }

   public function resultDashboard($exam_id)
   {
      $examAttempts = ExamAttempt::where('exam_id', $exam_id)
         ->where('user_id', Auth::id())
         ->get();
      $exam = Exam::where('id', $exam_id)->first();


      return view('student.results', compact(['examAttempts', 'exam']));
   }

   public function retakeExam($exam_id)
   {
      $examAttempt = ExamAttempt::where('user_id', Auth::user()->id)->where('exam_id', $exam_id)->latest()->first();
      $exam = Exam::with(['questions.answers'])->findOrFail($exam_id);
      $examAnswerIds = [];
      //ExamAttempt::where('id', $examAttempt->id)->delete();
      if (Gate::denies('retake', $exam_id)) {
         abort(403, 'Unauthorized action.');
      }
      return view('student.examv3', compact(['exam', 'examAnswerIds']));
   }

   public function examHistory()
   {
      $examAttempts = ExamAttempt::where('user_id', Auth::user()->id)->where('exam_status', 'Submitted')->latest()->get();
      return view('student.examHistory', compact('examAttempts'));
   }

   public function checkExamAttempt(Request $request)
   {
       $userId = Auth::id();
       // Get all exam attempts for the user
       $examAttempts = ExamAttempt::where('user_id', $userId)->get();
   
       if ($examAttempts->isEmpty()) {
           return response()->json(['status' => 'success', 'updated' => false, 'no_attempts' => true]);
       }
   
       $updated = false;
       $minutesDifference = 0;
   
       foreach ($examAttempts as $examAttempt) {
           $lastUpdatedTime = Carbon::parse($examAttempt->updated_at);
           $currentTime = Carbon::now();
           $minutesDifference = $lastUpdatedTime->diffInMinutes($currentTime);
   
           // Check if the time difference exceeds 10 minutes
           if ($minutesDifference > 3 && $examAttempt->exam_status != 'Submitted') {
               // Update the exam status to 'Submitted'
               $examAttempt->exam_status = 'Submitted';
               $examAttempt->save();
               $updated = true;
           }
       }
   
       return response()->json([
           'status' => 'success', 
           'updated' => $updated, 
           'no_attempts' => false, 
           'value' => $minutesDifference
       ]);
   }
   
}
