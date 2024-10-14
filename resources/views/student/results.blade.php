@extends('layout.student-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">
        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">
            <div class="block w-full overflow-x-auto">
                <div class="flex justify-between items-center px-3 py-2">
                    <h2 class="text-xl font-semibold">{{ $exam->exam_name }}</h2>
                    @can('retake', $exam->id)
                        <a href="{{ route('retakeExam', $exam->id) }}"
                            class="px-6 py-2 text-white bg-blue-700 rounded-lg">Retake Exam</a>
                    @endcan
                </div>

                @if ($examAttempts->count() > 0)
                    @php
                        $slno = 1;
                    @endphp

                    <table class="w-full bg-transparent border-collapse ">

                        <thead class="">
                            <tr>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Attempts
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Mark Secured
                                </th>
                                <th
                                    class="hidden px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 md:block bordeer-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Passing Status
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 bordeer-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Date & Time
                                </th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($examAttempts as $examAttempt)
                                <tr>
                                    <th
                                        class="p-4 px-6 text-base text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap text-blueGray-700 ">
                                        Attempt {{ $slno }}
                                    </th>
                                    <td
                                        class="p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        {{ $examAttempt->marks }}/{{ $examAttempt->full_mark }}
                                    </td>


                                    <td
                                        class="hidden p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 md:block whitespace-nowrap ">
                                        @if ($examAttempt->status == 0)
                                            Failed
                                        @else
                                            Passed
                                        @endif
                                    </td>
                                    <td class="p-4 px-6 align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                                        {{ $examAttempt->created_at }}
                                    </td>

                                </tr>
                                @php
                                    $slno++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
