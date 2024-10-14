@extends('layout.admin-layout')
@section('space-work')
    @if (isset($userAttempt) && isset($examAnswers))
        <div class="w-full p-8 ">
            <div class="grid grid-cols-3 p-4 mb-8 border border-gray-800 ">
                <div class="col-span-2">
                    <h2 class="mb-2 text-xl font-semibold">Name : {{ $userAttempt->user->name }}</h2>
                    <h2 class="text-lg font-semibold">Email ID : {{ $userAttempt->user->email }}</h2>
                </div>
                <div>
                    <h2 class="mb-2 text-xl font-semibold">Mark Secured :{{$userAttempt->marks}}/{{$userAttempt->full_mark}} </h2>
                    <h2 class="mb-2 text-xl font-semibold">Status : @if($userAttempt->status == 1)Passed @else Failed @endif</h2>
                </div>
            </div>

            @php
                $slNo = 1;
            @endphp
            @foreach ($examAnswers as $examAnswer)
                <div class="w-full">
                    <div class="px-4 flex">
                        <strong>{{$slNo}}:</strong> <div class="ms-2">{!! $examAnswer->question->question !!}</div>
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
                                        $score = $userAttempt->exams->mark_per_que;
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

                        <div class="text-right">{{ $score }}/{{$userAttempt->exams->mark_per_que}}</div>
                    </div>
                </div>
                @php
                    $slNo++;
                @endphp
            @endforeach

        </div>
    @else
        Error
    @endif
@endsection
