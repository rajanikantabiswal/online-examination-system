@extends('layout.student-layout')
@section('space-work')

<script>
    $(document).ready(function() {
        $('#space-work').hide();
        $.ajax({
            url: '{{ route('check.exam.attempt') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
               
                if (response.no_attempts) {
                   
                    $('#space-work').show();
                    return;
                }

                
                if (response.updated) {
                    console.log(response.value);
                    location.reload();
                    
                } else {
                  
                    $('#space-work').show();
                   
                    
                  
                }
            },
            error: function(xhr) {
                $('#space-work').show();
                console.error(xhr.responseText);
            }
        });

       
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        var timerElements = document.querySelectorAll('[id^="timer_"]');

        
        timerElements.forEach(function(timerElement) {
            var updatedAtString = timerElement.innerText.trim(); // Get the `updated_at` time from the inner text
            var updatedAt = new Date(updatedAtString); // Convert string to Date object

            // Add 10 minutes to the updated_at time
            var deadline = new Date(updatedAt.getTime() + 3 * 60 * 1000); // Add 10 minutes (in milliseconds)

            function updateTimer() {
                var now = new Date().getTime();
                var timeLeft = deadline - now;

                // Calculate minutes and seconds remaining
                var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                // Display the updated time in the DOM
                timerElement.innerHTML = minutes + "m " + seconds + "s left";

                // If the countdown is finished, refresh the page
                if (timeLeft <= 0) {
                    clearInterval(timerInterval); // Clear the timer
                    location.reload(); // Refresh the page
                }
            }

            // Start the countdown timer, updating every second
            var timerInterval = setInterval(updateTimer, 1000);
        });
    });
</script>
    <div class="relative w-full h-full p-3 lg:p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">

            <div class="block w-full overflow-x-auto">

                @if ($exams->count() > 0)
                    @php
                        $slno = 1;
                    @endphp

                    <table class="w-full bg-transparent border-collapse ">

                        <thead class="">
                            <tr>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    #
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Exam Name
                                </th>
                                <th
                                    class="hidden px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 md:block bordeer-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Time
                                </th>
                                <th
                                    class="px-6 py-3 font-semibold text-left uppercase border border-l-0 border-r-0 bordeer-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">

                                </th>

                            </tr>
                        </thead>



                        <tbody>
                            @foreach ($exams as $exam)
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
                                        class="hidden p-4 px-6 text-base align-middle border-t-0 border-l-0 border-r-0 md:block whitespace-nowrap ">
                                        {{ $exam->time }} Hr
                                    </td>
                                    <td class="p-4 px-6 align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                                        @if ($attemptedExams->contains($exam))
                                            <span
                                                class="text-white bg-gray-800 px-3 py-1.5 rounded-lg">{{ $exam->examAttempts->last()->exam_status }}</span>
                                            @if ($exam->examAttempts->last()->exam_status == 'pending')
                                                <a class="text-white bg-blue-600 px-3 py-1.5 rounded-lg"
                                                    href="{{ route('examView', $exam->exam_passkey) }}">Resume Exam<i
                                                        class="ri-external-link-line ps-2"></i></a>
                                                <span class="text-red-500" id="timer_{{$exam->id}}">{{$exam->examAttempts->last()->updated_at}}</span>
                                            @else
                                                @can('retake', $exam->id)
                                                    <a class="text-white bg-green-600 px-3 py-1.5 rounded-lg"
                                                        href="{{ route('retakeExam', $exam->id) }}">Retake<i
                                                            class="ri-external-link-line ps-2"></i></a>
                                                @endcan
                                            @endif
                                        @else
                                            <a class="text-white bg-blue-600 px-3 py-1.5 rounded-lg"
                                                href="{{ route('examView', $exam->exam_passkey) }}">Start Exam<i
                                                    class="ri-external-link-line ps-2"></i></a>
                                        @endif

                                    </td>

                                </tr>
                        </tbody>
                        @php
                            $slno++;
                        @endphp
                @endforeach
                </table>
            @else
                <h2 class="w-full mt-10 text-base font-semibold text-center ">No Exam Found!</h2>
                @endif

            </div>

        </div>

    </div>

    
@endsection
