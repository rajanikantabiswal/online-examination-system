@extends('layout/admin-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">
            <div class="px-4 py-3 mb-0 border-0 rounded-t">
                <div class="flex flex-wrap items-center">
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                        <h3 class="text-2xl font-semibold text-blueGray-700 ">Exams</h3>
                    </div>
                </div>
            </div>
            <div class="block w-full overflow-x-auto">
                @if ($exams->count() > 0)
                    @php
                        $slno = 1;
                    @endphp


                    <table class="items-center w-full bg-transparent border-collapse ">

                        <thead class="">
                            <tr>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    #
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Exam Name
                                </th>

                                <th
                                    class="px-6 py-3 font-semibold text-center uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Total Responses
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-center uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    View Responses
                                </th>


                            </tr>
                        </thead>


                        @foreach ($exams as $exam)
                            <tbody>
                                <tr>
                                    <th
                                        class="p-4 px-6 text-base text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap text-blueGray-700 ">
                                        {{ $slno }}
                                    </th>
                                    <td
                                        class="p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        {{ $exam->exam_name }}
                                    </td>

                                    <td
                                        class="p-4 px-6 text-base text-center align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        {{$exam->exam_attempts_count}}
                                    </td>
                                    
                                    <td
                                        class="p-4 px-6 text-2xl text-center text-blue-500 border-t-0 border-l-0 border-r-0 align-center whitespace-nowrap">
                                        <a href="{{ route('getExamResponses',['examId' => $exam->id] ) }}"><i class="ri-eye-line"></i></a>
                                    </td>
                                    

                                    

                                </tr>
                            </tbody>
                            @php
                                $slno++;
                            @endphp
                        @endforeach
                    </table>
                @else
                    <h2 class="w-full mt-10 text-base font-semibold text-center ">No record found</h2>
                @endif

            </div>

        </div>


    </div>



    <script>
        $(document).ready(function() {
     
        });
    </script>

@endsection
