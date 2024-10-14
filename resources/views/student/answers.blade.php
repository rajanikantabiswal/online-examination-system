@extends('layout.layout-common')
@section('space-work')


    @if (isset($examAttempt) && isset($examAnswers))
        <div class="w-full p-3 ">
            <div class="grid grid-cols-1 lg:grid-cols-3 p-2 lg:p-4 mb-8 border border-gray-800 ">
                <div class="col-span-2">
                    <h2 class=" lg:text-xl font-semibold">Name : {{ $examAttempt->user->name }}</h2>
                    <h2 class="lg:text-xl font-semibold">Email ID : {{ $examAttempt->user->email }}</h2>
                </div>
                <div>
                    <h2 class=" lg:text-xl font-semibold">Mark Secured :{{$examAttempt->marks}}/{{$examAttempt->full_mark}} </h2>
                    <h2 class=" lg:text-xl font-semibold">Status : @if($examAttempt->status == 1)<span class="text-green-700">Passed</span> @else <span class="text-red-500">Failed</span> @endif</h2>
                </div>
            </div>

            @php
                $slNo = 1;
            @endphp
            @foreach ($examAnswers as $examAnswer)
                <div class="w-full mt-3">
                    <div class="px-4 flex">
                        <strong>{{$slNo}}:</strong><div class="ms-2 prose font-semibold"> {!! $examAnswer->question->question !!}</div>
                    </div>
                    <div class="px-4 py-4">
                        @php
                            $score = 0;
                            $correctAnswer = '';
                        @endphp
                        <ul>
                            @foreach ($examAnswer->question->answers as $answer)
                                @php
                                    $isCorrect = $answer->is_correct == 1;
                                    if ($isCorrect) {
                                        $correctAnswer = $answer->answer;
                                    }
                                    $isSelected = $examAnswer->answer_id == $answer->id;
                                    if ($isCorrect && $isSelected) {
                                        $score = $examAttempt->exams->mark_per_que;
                                    }
                                @endphp
                                <li class="px-4 mb-2">
                                    {{ $answer->answer }}
                                    @if ($isSelected && !$isCorrect)
                                        <i class="text-2xl text-red-500 ri-close-line"></i>
                                    @elseif ($isSelected && $isCorrect)
                                        <i class="text-2xl text-green-600 ri-check-line"></i>
                                    @else
                                    @endif
                                </li>
                            @endforeach

                        </ul>
                        <p class="px-4 font-semibold text-green-600">Correct Answer: {{ $correctAnswer }}</p>

                        <div class="text-right">{{ $score }}/{{$examAttempt->exams->mark_per_que}}</div>
                    </div>
                </div>
                <hr>
                @php
                    $slNo++;
                @endphp
            @endforeach

        </div>
        <div class="w-full text-center mb-10">
            @can('retake', $examAttempt->exam_id )
            <a href="{{route('retakeExam', $examAttempt->exams->id)}}" class="px-4 py-2 text-white bg-red-500 rounded ">Retake</a>
            @endcan
            <a href="/" class="px-4 py-2 text-white bg-green-500 rounded ">Back to Home</a>
        </div>
    @else
        Error
    @endif
@endsection
