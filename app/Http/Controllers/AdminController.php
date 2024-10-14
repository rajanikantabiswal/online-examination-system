<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Imports\QnaImport;
use App\Models\ExamAnswer;

use App\Models\ExamAttempt;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\CandidateImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{


    //exam dashboard load
    public function handleExam($exId = null){
        if($exId){
            return $this->viewExam($exId);
        }else{
            return $this->examDashboard();
        }
    }

    public function viewExam($exId){
        $questions = Question::where('exam_id', $exId)
        ->with('answers')
        ->get();
        $exams = Exam::where('id',$exId)->get();
        return view('admin.qna', ['questions' => $questions, 'exams' => $exams]);
    }
    public function examDashboard()
    {
       
        $exams = Exam::get();
        return view('admin.exams', compact('exams'));
    }

    // add exam
    public function addExam(Request $request)
    {
        try {
            $exam_passkey = Str::random(20);
            $exam = new Exam();
            $exam->exam_name = $request->exam;
            $exam->time = $request->time;
            $exam->exam_passkey = $exam_passkey;
            //$exam->mark_per_que = $request->mark_per_que;
            $exam->passing_criteria = $request->passing_criteria;
            $exam->retake = $request->retake;
            $exam->view_result = $request->has('view_result') ? 1 : 0;
            $exam->save();

            return response()->json(['success' => true, 'msg' => 'Subject added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getExamDetails($id)
    {
        try {
            $exam = Exam::where('id', $id)->get();
            return response()->json(['success' => true, 'data' => $exam]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function updateExam(Request $request)
    {
        try {
            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->time = $request->time;
            //$exam->mark_per_que = $request->mark_per_que;
            $exam->retake = $request->retake;
            $exam->view_result = $request->has('view_result') ? 1 : 0;
            $exam->save();

            return response()->json(['success' => true, 'msg' => 'Exam updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function deleteExam(Request $request)
    {
        try {

            Exam::where('id', $request->id)->delete();

            return response()->json(['success' => true, 'msg' => 'exam deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function toggleExamStatus(Request $request){
        try {
            $exam = Exam::find($request->examId);
            $exam->is_active= $request->is_active;
            $exam->save();
            return response()->json(['success' => true, 'msg' => 'Exam updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function qnaDashboard()
    {
        $exams = Exam::all();
        $questions = Question::with('answers')->get();
        return view('admin.qna', ['questions' => $questions, 'exams' => $exams]);
    }
    //add QNA
    public function addQna(Request $request)
    {

        try {
            $now = Carbon::now();
            $questionId = Question::insertGetId([
                'question' => $request->question,
                'exam_id' =>$request->examId,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            foreach ($request->answers as $answer) {
                $is_correct = 0;
                if ($request->is_correct == $answer) {
                    $is_correct = 1;
                }

                Answer::create([
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'is_correct' => $is_correct
                ]);
            }

            return response()->json(['success' => true, 'msg' => 'Question added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }

        
    }

    //update QNA
    public function updateQna(Request $request)
    {

        try {
            $now = Carbon::now();
            Question::find($request->question_id)->update(['question' => $request->question, 'updated_at' => $now]);

            if (isset($request->answers)) {
                foreach ($request->answers as $key=>$value) {
                    $is_correct = 0;
                    if ($request->is_correct == $value) {
                        $is_correct = 1;
                    }

                    Answer::where('id', $key)->update([
                        'question_id' => $request->question_id,
                        'answer' => $value,
                        'is_correct' => $is_correct
                    ]);
                }
            }

            if (isset($request->new_answers)) {
                foreach ($request->new_answers as $answer) {
                    $is_correct = 0;
                    if ($request->is_correct == $answer) {
                        $is_correct = 1;
                    }

                    Answer::create([
                        'question_id' => $request->question_id,
                        'answer' => $answer,
                        'is_correct' => $is_correct
                    ]);
                }
            }

            return response()->json(['success' => true, 'msg' => 'Subject deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    //delete Answer
    public function deleteAnswer(Request $request)
    {
        try {

            Answer::where('id', $request->id)->delete();

            return response()->json(['success' => true, 'msg' => 'Answer deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    //delete Qna
    public function deleteQna(Request $request)
    {
        try {

            Question::where('id', $request->id)->delete();

            return response()->json(['success' => true, 'msg' => 'Subject deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getQnaDetails(Request $request)
    {
        $qna = Question::where('id', $request->qid)->with('answers')->get();

        return response()->json(['data' => $qna]);
    }


    public function importQna(Request $request)
    {
        $file = $request->file('file');
        $examId = $request->examId;
        try {
            Excel::import(new QnaImport($examId), $file);


            return response()->json(['success' => true, 'msg' => "Not added"]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => "Failed"]);
        }
    }



    //candidate 
    public function candidateDashboard(){
        $candidates = User::where('is_admin', 0)->get();
        return view('admin.candidates', compact('candidates'));
    }
     // add candidate
     public function addCandidate(Request $request)
     {
        // $password = Str::random(8);

         try {
             $user = User::create([
                'name' => $request->name,
                'email' =>$request->email,
                'password'=>Hash::make($request->password)

             ]);
            
                // $url = URL::to('/');
                // $data['name']= $request->name;
                // $data['url'] = $url;
                // $data['email'] = $request->email;
                // $data['password']=$password;
                // $data['title'] = 'You have registerd on OES';
                // Mail::send('registrationMail', ['data' => $data], function ($message) use ($data) {
                //     $message->to($data['email'])->subject($data['title']);
                // });
        


 
             return response()->json(['success' => true, 'msg' => 'Candidate added successfully!']);
         } catch (\Exception $e) {
             return response()->json(['success' => false, 'msg' => $e->getMessage()]);
         }
     }

     public function getCandidateDetails($id){
        try {
            $candidate = User::where('id', $id)->get();
            return response()->json(['success' => true, 'data' => $candidate]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
     }

     // update candidate
     public function updateCandidate(Request $request)
     {
        $password = Str::random(8);

         try {
             User::where('id', $request->id)->update([
                'name' => $request->name,
                'email' =>$request->email
             ]);
            
                // $url = URL::to('/');
                // $data['name']= $request->name;
                // $data['url'] = $url;
                // $data['email'] = $request->email;
                // $data['password']=$password;
                // $data['title'] = 'You have registerd on OES';
                // Mail::send('registrationMail', ['data' => $data], function ($message) use ($data) {
                //     $message->to($data['email'])->subject($data['title']);
                // });
        


 
             return response()->json(['success' => true, 'msg' => 'Candidate added successfully!']);
         } catch (\Exception $e) {
             return response()->json(['success' => false, 'msg' => $e->getMessage()]);
         }
     }

    //  delete Candidate
    public function deleteCandidate(Request $request){
        try {

            User::where('id', $request->id)->delete();

            return response()->json(['success' => true, 'msg' => 'User deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    //import Candidate
    public function importCandidate(Request $request)
    {
        try {   
            $examId = $request->has('import_examId') ? $request->input('import_examId') : null;
            $import = new CandidateImport($examId);

            Excel::import($import, $request->file('file'));
            $counts = $import->getCounts();
            return response()->json([
                'success' => true,
                'newUsers' => $counts['newUsersCount'],
                'existingUsers' => $counts['existingUsersCount']
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }


    //view responses
    public function responsesDashboard(){
        $exams = Exam::has('examAttempts')->withCount('examAttempts')->get();
        // return $examsWithAttemptCounts;
        // $exams = Exam::get();
        return view('admin.responses', compact('exams'));
        
    }

    
    

    public function getExamResponses($examId) {
        // Subquery to get the latest attempt time for each user
        $examAttempts = ExamAttempt::where('exam_id', $examId)
            ->latest()->get();
    
        // Main query to join with the subquery and handle ties by selecting the maximum id
        // $examAttempts = ExamAttempt::with('user')
        //     ->orderBy('created_at', 'desc')
        //     ->get();
    
        return view('admin.getExamResponses', compact('examAttempts'));
       //return $examAttempts;
    }
    

    public function getUserResponses($attemptId){
        $examAnswers = ExamAnswer::with('question.answers')
         ->where('attempt_id', $attemptId)
         ->get();
      $userAttempt= ExamAttempt::with(['user', 'exams'])->where('id', $attemptId)->first();
      //return $user;
      return view('admin.getUserResponses', compact('examAnswers', 'userAttempt'));
    }



}
