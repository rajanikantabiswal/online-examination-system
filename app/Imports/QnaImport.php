<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log; // Ensure the Log facade is imported

class QnaImport implements ToModel
{

    protected $examId;

    public function __construct($examId)
    {
        $this->examId = $examId;
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


         //Log::info($row);
        if($row[0] != 'question'){
            $now = Carbon::now();
            $questionId = Question::insertGetId([
                'exam_id' => $this->examId,
                'question' => $row[0],
                'created_at' => $now,
                'updated_at' => $now
            ]);



            for($i = 1; $i < count($row)-1; $i++){
                $is_correct = 0;
                if($row[7] == $row[$i]){
                    $is_correct = 1;
                }
                if($row[$i] != null){
                    Answer::create([
                        'question_id' => $questionId,
                        'answer' => $row[$i],
                        'is_correct' => $is_correct
                    ]);
                }
            }
        }
       
        // return new Question([
            
        // ]);
    }
}
