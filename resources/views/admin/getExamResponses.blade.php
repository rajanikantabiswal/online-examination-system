@extends('layout/admin-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">

            <div class="block w-full overflow-x-auto">
                @if ($examAttempts->count() > 0)
                    @php
                        $slno = 1;
                    @endphp


                    <table class="w-full bg-transparent border-collapse ">

                        <thead class="">
                            <tr>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    #
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Candidate Name
                                </th>

                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Mark Secured
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    PASS/FAIL
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-center uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    VIEW ANSWERS
                                </th>

                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    DATE & TIME
                                </th>



                            </tr>
                        </thead>


                        @foreach ($examAttempts as $examAttempt)
                            <tbody>
                                <tr>
                                    <th
                                        class="p-4 px-6 text-base text-left align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap text-blueGray-700 ">
                                        {{ $slno }}
                                    </th>
                                    <td
                                        class="p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        {{ $examAttempt->user->name }}
                                    </td>

                                    <td
                                        class="p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        {{$examAttempt->marks}}/{{$examAttempt->full_mark}}
                                    </td>
                                    <td
                                        class="p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        @if($examAttempt->status == 1)
                                        Passed
                                        @else
                                        Failed
                                        @endif
                                    </td>
                                    <td
                                        class="p-4 px-6 text-2xl text-center text-blue-500 border-t-0 border-l-0 border-r-0 align-center whitespace-nowrap">
                                        <a href="{{ route('getUserResponses',['attemptId' => $examAttempt->id] ) }}"><i class="ri-eye-line"></i></a>
                                    </td>
                                    <td
                                        class="p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap ">
                                        {{ $examAttempt->created_at}}
                                    </td>

                                </tr>
                            </tbody>
                            @php
                                $slno++;
                            @endphp
                        @endforeach
                    </table>
                @else
                    <h2 class="w-full mt-10 text-base font-semibold text-center ">No Question Found!</h2>
                @endif
            </div>

        </div>


    </div>



    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
