<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnrollmentController extends Controller
{
    public function enrollStudents($exId)
    {
        $exam = Exam::findOrFail($exId);
        $candidates = User::where('is_admin', 0)->get(); // or wherever you get the list of candidates
        $assignedCandidates = $exam->users->pluck('id')->toArray(); // Get assigned candidate IDs

        return view('admin.enrollCandidates', compact('exam', 'candidates', 'assignedCandidates'));
    }

    public function enrollCandidatesToExam(Request $request)
    {

        $exam = Exam::findOrFail($request->examId);
        $candidates = $request->candidate_ids;

        $exam->users()->sync($candidates);
        return redirect()->back();
    }
}
