<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .disable-selection {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            pointer-events: none;
        }

        .hidden {
            display: none;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 4px;
        }

        .grid-item {
            height: 20px;
            background-color: gray;
            transition: background-color 0.3s;
        }

        .active {
            background-color: green;
        }
    </style>
</head>

<body class="bg-gray-100">


    @if (isset($examAttempt))
        <div
            class="min-h-[10vh] py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30  ">


            <a href="/" data-tooltip-target="tooltip-right" data-tooltip-placement="right" type="button"
                class="ms-3 mb-2 md:mb-0  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center  :bg-blue-700 :ring-blue-800"><i
                    class="ri-home-3-line text-3xl"></i></a>

            <div id="tooltip-right" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip ">
                Back to Dashboard
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <ul class="flex items-center ml-auto">

                <button id="fullscreen-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        class="rounded-full hover:bg-gray-100 :bg-gray-800" viewBox="0 0 24 24" style="fill: gray;">
                        <path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"></path>
                    </svg>
                </button>
                <script>
                    const fullscreenButton = document.getElementById('fullscreen-button');

                    fullscreenButton.addEventListener('click', toggleFullscreen);

                    function toggleFullscreen() {
                        if (document.fullscreenElement) {

                            document.exitFullscreen();
                        } else {

                            document.documentElement.requestFullscreen();
                        }
                    }
                </script>

                <li class="ml-3 dropdown">
                    <button type="button" class="flex items-center dropdown-toggle">
                        <div class="relative flex-shrink-0 w-10 h-10">
                            <div class="p-1 bg-white rounded-full focus:outline-none focus:ring">
                                <img class="w-8 h-8 rounded-full"
                                    src="https://laravelui.spruko.com/tailwind/ynex/build/assets/images/faces/9.jpg"
                                    alt="" />
                                <div
                                    class="absolute top-0 w-3 h-3 border-2 border-white rounded-full left-7 bg-lime-400 animate-ping">
                                </div>
                                <div
                                    class="absolute top-0 w-3 h-3 border-2 border-white rounded-full left-7 bg-lime-500">
                                </div>
                            </div>
                        </div>
                        <div class="p-2 text-left md:block">
                            <h2 class="text-sm font-semibold text-gray-800 capitalize ">
                                @if (auth()->check())
                                    {{ auth()->user()->name }}
                                @endif

                            </h2>
                            <p class="text-xs text-gray-500">Candidate</p>
                        </div>
                    </button>

                </li>
            </ul>
        </div>
        <div class="flex flex-col items-center min-h-[90vh] px-4 pt-20 space-y-4 lg:space-y-6">
            <h2 class="mt-10 text-3xl text-center lg:text-5xl">You have already submitted this exam</h2>
            <a href="/result-dashboard/{{ $examAttempt->id }}" class="px-6 py-2 text-white bg-green-700 rounded">View
                Result</a>
            @can('retake', $examAttempt->exam_id)
                <a href="{{ route('retakeExam', $examAttempt->exam_id) }}"
                    class="px-6 py-2 text-white bg-blue-700 rounded">Retake Exam</a>
            @endcan
            {{-- <a href="{{ route('retakeExam', $examAttempt->exam_id) }}"
                    class="px-6 py-2 text-white bg-blue-700 rounded">Retake Exam</a> --}}

        </div>
    @else
        <div id="welcome-main" class="min-h-screen flex items-center justify-center">

            <div id="welcomeDiv" class="bg-white p-8 rounded-lg shadow-lg text-center">
                <h1 class="text-2xl font-bold text-gray-700 mb-4">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-lg text-gray-600 mb-6">Please click the button below to start
                    your
                    exam.</p>

                <button id="proceedBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Proceed to next
                </button>
            </div>

            <div id="permissionDiv" class="hidden bg-white p-8 rounded-lg shadow-lg text-center">
                <h1 class="text-2xl font-bold text-gray-700 mb-4">Camera Permission</h1>
                <p class="text-lg text-gray-600 mb-6">We need access to your camera to proceed.</p>

                <button id="grantPermissionBtn"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Grant Permission
                </button>

                <!-- Error Message Box (hidden by default) -->
                <div id="errorBox" class="hidden bg-red-100 text-red-600 mt-4 p-4 rounded-lg">
                    <p id="errorMessage"></p>
                </div>

                <!-- Manual Enable Box (hidden by default) -->
                <div id="manualEnableBox" class="hidden bg-yellow-100 text-yellow-600 mt-4 p-4 rounded-lg">
                    <p>Please manually enable the camera and microphone permissions in your browser settings.</p>
                </div>
            </div>

            <!-- Instructions Div (hidden by default) -->
            <div id="instructionsDiv"
                class="hidden bg-white p-8 rounded-lg shadow-lg text-center flex flex-col items-center">


                <!-- Camera Feed -->
                <div class="mb-6 flex justify-center">
                    <video id="cameraFeed" width="320" height="240" autoplay
                        class="border border-gray-300"></video>
                </div>
                <div class="w-[70%] h-80 overflow-y-scroll p-6 border border-gray-300 bg-gray-100 rounded-lg">
                    <h2 class="text-xl font-bold mb-4">Exam Instructions and Guidelines</h2>
                    <p class="mb-4">
                        Please read the following rules carefully before starting your exam.
                        Strict adherence to these guidelines is necessary to ensure a smooth and fair exam experience.
                    </p>

                    <h3 class="text-lg font-semibold mb-2">Exam Conduct Guidelines:</h3>
                    <div class="text-left">
                        <ul class="list-disc list-inside mb-4">
                            <li><strong>Full-Screen Mode Requirement:</strong>
                                <ul class="list-disc list-inside ml-4">
                                    <li>The exam must be conducted in full-screen mode at all times.</li>
                                    <li><strong>Do not attempt to exit full-screen mode.</strong> If you exit
                                        full-screen mode, your exam will be submitted automatically after 10 seconds.
                                    </li>
                                </ul>
                            </li>
                            <li class="mt-2"><strong>No New Tabs Allowed:</strong>
                                <ul class="list-disc list-inside ml-4">
                                    <li><strong>Do not attempt to open any new tabs</strong> during the exam.</li>
                                    <li>Opening a new tab will cause the exam to stop immediately, and it will be
                                        automatically submitted.</li>
                                </ul>
                            </li>
                            <li class="mt-2"><strong>Accidental Tab Closure or System Interruption:</strong>
                                <ul class="list-disc list-inside ml-4">
                                    <li>If the exam tab is accidentally closed or interrupted due to an unforeseen issue
                                        (e.g., network disconnect, browser crash):</li>
                                    <li>You <strong>must log back in within 10 minutes</strong> to resume the exam from
                                        where you left off.</li>
                                    <li>If you fail to log in within 10 minutes, your exam will be <strong>automatically
                                            submitted.</strong></li>
                                    <li>Ensure you have a stable internet connection to prevent unnecessary
                                        interruptions.</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="text-left">
                        <h3 class="text-lg font-semibold mb-2">Additional Important Reminders:</h3>
                        <ul class="list-disc list-inside mb-4">
                            <li><strong>Do not refresh the page</strong> or navigate away from the exam tab while the
                                test is in progress.</li>
                            <li>Any violation of the above rules will result in your exam being submitted immediately,
                                and no further changes will be allowed.</li>
                            <li>If you face any technical difficulties, please contact support immediately.</li>
                        </ul>

                        <p class="mb-4">
                            By proceeding with the exam, you acknowledge that you have read and understood these
                            instructions.
                        </p>
                    </div>

                </div>

                <!-- Terms and Conditions Checkbox -->
                <div class="my-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" id="termsCheckbox" class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-600">I accept the terms and conditions and instructions</span>
                    </label>
                </div>

                <!-- Next Button (disabled by default) -->
                <button id="nextBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
                    disabled>
                    Next
                </button>
            </div>

        </div>


        <div id="examInfo"
            class=" hidden flex flex-col items-center justify-center w-full min-h-screen gap-4 p-4 text-center">
            <table class="w-full text-left lg:w-1/2">
                <tr class="px-2 py-4">
                    <td class="px-4 py-2 border">Exam Name:</td>
                    <th class="px-4 py-2 border">{{ $exam->exam_name }}</th>
                </tr>
                <tr class="px-2 py-4">
                    <td class="px-4 py-2 border">Candidate Name:</td>
                    <th class="px-4 py-2 border">{{ Auth::user()->name }}</th>
                </tr>
                <tr class="px-2 py-4 ">
                    <td class="px-4 py-2 border">Total Questions:</td>
                    <td class="px-4 py-2 border">{{ count($exam->questions) }}</td>
                </tr>
                <tr class="px-2 py-4 ">
                    <td class="px-4 py-2 border">Total Marks:</td>
                    <td class="px-4 py-2 border">{{ $exam->mark_per_que * count($exam->questions) }}</td>
                </tr>
                <tr class="px-2 py-4 ">
                    <td class="px-4 py-2 border">Duration:</td>
                    <td class="px-4 py-2 border">{{ $exam->time }} Hr</td>
                </tr>
            </table>
            <div>

                <button id="startExamBtn" data-user-id="{{ Auth::user()->id }}" data-exam-id="{{ $exam->id }}"
                    class="px-6 py-2 font-semibold text-white bg-red-500 rounded disabled:bg-red-300">Start
                    Test</button>
            </div>

        </div>

        <div id="examPannel" class="hidden min-h-screen">

            <nav class="fixed top-0 z-40 w-full bg-white border-b border-gray-200  ">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start rtl:justify-end">
                            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                                aria-controls="logo-sidebar" type="button"
                                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200  :bg-gray-700 :ring-gray-600">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="#FF0000" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                    </path>
                                </svg>
                            </button>


                            <div class="flex items-center justify-between">
                                <h1 class="mr-4 text-2xl font-bold">{{ $exam->exam_name }}</h1>
                                <div class="px-2 text-2xl font-bold text-red-500 rounded ">
                                    <span id="examTimer"></span>
                                </div>
                                <div id="auto-alert" class="hidden">
                                    <div class="p-2 bg-orange-600 items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex"
                                        role="alert">
                                        <span
                                            class="flex rounded-full bg-orange-500 uppercase px-2 py-1 text-xs font-bold mr-3">Alert!</span>
                                        <span id="alert-message" class="font-semibold mr-2 text-left flex-auto">Last 1
                                            min
                                            left</span>
                                        <svg class="fill-current opacity-75 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center ms-3">
                                <div>
                                    <span class="font-bold">Name: </span>
                                    <span id="username">{{ Auth::user()->name }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <aside id="logo-sidebar"
                class="fixed top-0 left-0 z-30 w-80 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0  "
                aria-label="Sidebar">
                <div class="px-5 py-2">
                    <h3 class="font-semibold text-gray-700 text-lg mb-3">Questions List</h3>
                    <div class="h-[55vh] overflow-y-auto bg-white ">
                        <div id="sidebar" class="pe-3 py-2">
                            <div id="questionList" class="grid grid-cols-5 gap-2">
                                @php $qCount = 0; @endphp
                                @foreach ($exam->questions as $question)
                                    <button
                                        class="px-4 py-2 text-left bg-white rounded shadow-md  hover:bg-gray-200 :bg-gray-600 question-btn"
                                        data-index="{{ $qCount }}">
                                        <div class="font-semibold">{{ ++$qCount }}</div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <h3 class="font-semibold text-gray-700 text-lg mb-3 underline">Legands</h3>
                        <div class="flex flex-col gap-2">
                            <div>
                                <button
                                    class="px-4 py-2 text-left bg-white rounded shadow-md  hover:bg-gray-200 :bg-gray-600">
                                    <div class="font-semibold">Q</div>
                                </button>
                                <span>Not answered</span>
                            </div>
                            <div>
                                <button
                                    class="px-4 py-2 text-left bg-green-500 text-white rounded shadow-md  hover:bg-gray-200 :bg-gray-600">
                                    <div class="font-semibold">Q</div>
                                </button>
                                <span>Answered</span>
                            </div>
                            <div>
                                <button
                                    class="px-4 py-2 text-left bg-orange-500 text-white rounded shadow-md  hover:bg-gray-200 :bg-gray-600">
                                    <div class="font-semibold">Q</div>
                                </button>
                                <span>Marked for review</span>
                            </div>
                        </div>
                    </div>
                </div>

            </aside>

            <div class="p-4 sm:ml-80 z-30">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg  mt-14">

                    <div id="questionPanel" class="">
                        <form id="examForm">
                            @csrf
                            <input type="hidden" name="attempt_id" id="attempt_id">
                            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                            <div id="questionsContainer" class="flex flex-col">
                                @php $qCount = 1; @endphp
                                @foreach ($exam->questions as $question)
                                    <div class="question-item mb-6 hidden">
                                        <div class="px-4 py-2  disable-selection">
                                            <div>

                                                <div class="prose"><span><strong>{{ $qCount++ }}.</strong></span>
                                                    {!! $question->question !!}</div>
                                            </div>
                                            <input type="hidden" name="q[]" value="{{ $question->id }}">
                                            <input type="hidden" name="ans_{{ $qCount - 1 }}"
                                                id="ans_{{ $qCount - 1 }}">
                                        </div>
                                        <div class="grid grid-cols-1 space-y-1.5 px-4 py-4">
                                            @foreach ($question->answers as $answer)
                                                <div class="flex items-center choice-div py-3 px-2 bg-gray-50 rounded"
                                                    data-id="{{ $answer->id }}">
                                                    <input id="choice_{{ $answer->id }}"
                                                        name="radio_{{ $qCount - 1 }}" type="radio"
                                                        value="{{ $answer->id }}"
                                                        data-question-id="{{ $question->id }}"
                                                        data-id="{{ $qCount - 1 }}"
                                                        class="w-4 h-4 border-gray-300 select_ans focus:ring-2 focus:ring-blue-300"
                                                        @if (in_array($answer->id, $examAnswerIds)) checked @endif>
                                                    <label for="choice_{{ $answer->id }}"
                                                        class="block ml-2 text-sm font-medium text-gray-900 ">
                                                        {{ $answer->answer }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-start mt-4 gap-2">
                                <button id="reviewButton" type="button"
                                    class="px-4 py-2 font-semibold text-white bg-orange-500 rounded">Mark for
                                    review</button>
                                <button id="prevButton" type="button"
                                    class="px-4 py-2 font-semibold text-white bg-gray-500 rounded"
                                    disabled>Previous</button>
                                <button id="nextButton" type="button"
                                    class="px-4 py-2 font-semibold text-white bg-blue-500 rounded">Next</button>
                                <button id="examFormSubmit" type="submit"
                                    class="px-4 py-2 font-semibold text-white bg-green-500 rounded">Submit</button>


                            </div>
                        </form>
                    </div>

                </div>

            </div>

            <div id="camera-box" class="absolute w-[10vw] h-[10vh] z-50 top-10 right-10">
                <video id="video" autoplay class="w-[100%] h-[100%] object-content"></video>
            </div>

        </div>

        <!-- Modal Structure -->
        <div id="confirmationModal"
            class="hidden fixed z-50 top-0 left-0 w-full h-full flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-4 rounded shadow-lg min-w-[50vw]">
                <h2 class="text-lg font-bold mb-2">Confirm Submission</h2>
                <p>Total Questions: <span id="totalQuestions"></span></p>
                <p>Questions Attended: <span id="questionsAttended"></span></p>
                <div class="mt-4 flex justify-end">
                    <button id="confirmSubmit" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Confirm</button>
                    <button id="cancelSubmit" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                </div>
            </div>
        </div>


        <div x-data="{ modalIsOpen: false, timer: 10, countdown: null }" x-init="document.addEventListener('fullscreenchange', function() {
            if (!document.fullscreenElement) {
                if (!document.getElementById('examPannel').classList.contains('hidden')) {
                    modalIsOpen = true;
                    timer = 10;
                    countdown = setInterval(() => {
                        if (timer > 0) {
                            timer--;
                        } else {
                            clearInterval(countdown);
                            localStorage.removeItem('remainingTime');
                            submitForm();
                        }
                    }, 1000);
                }
            } else {
                clearInterval(countdown); // Stop timer if modal closes
                timer = 10; // Reset timer if fullscreen is re-entered
            }
        });">

            <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen"
                @click.self="modalIsOpen = false"
                class="fixed inset-0 z-40 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
                role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">

                <!-- Modal Dialog -->
                <div x-show="modalIsOpen"
                    x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
                    x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
                    class="flex max-w-lg flex-col gap-4 overflow-hidden rounded-xl border border-slate-300 bg-white text-slate-700   ">

                    <!-- Dialog Body -->
                    <div class="px-4 py-4">
                        <div class="flex justify-end">
                            <button @click="modalIsOpen = false; clearInterval(countdown); timer = 15;"
                                aria-label="close modal">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                                    stroke="currentColor" fill="none" stroke-width="1.4" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 ">
                                You have exited fullscreen mode!
                            </h3>

                            <p class="text-lg font-medium text-red-600 mb-5">Your exam will be submitted in <span
                                    x-text="timer"></span> seconds.</p>

                            <button @click="modalIsOpen = false; clearInterval(countdown); timer = 15;" type="button"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 :ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Continue exam
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif





    <!--show alert modal-->
    <script>
        function showAlert(message) {
            const alert = document.getElementById("auto-alert");
            const alertMessage = document.getElementById("alert-message");
            alert.classList.remove("hidden");
            alertMessage.textContent = message; // Make the alert visible

            setTimeout(function() {
                alert.classList.add("hidden"); // Hide the alert after 4 seconds
            }, 4000);
        }
    </script>




    <script>
        let permissionDeniedCount = 0; // Track the number of denied permissions
        let timerInterval;

        document.getElementById('proceedBtn').addEventListener('click', function() {
            document.getElementById('welcomeDiv').classList.add('hidden');
            document.getElementById('permissionDiv').classList.remove('hidden');
        });

        document.getElementById('grantPermissionBtn').addEventListener('click', async function() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    //audio: true
                });
                permissionDeniedCount = 0; // Reset if permission is granted

                // Show the camera feed
                document.getElementById('cameraFeed').srcObject = stream;

                // Hide the permission div and show the instructions div
                document.getElementById('permissionDiv').classList.add('hidden');
                document.getElementById('instructionsDiv').classList.remove('hidden');

                // Start monitoring audio levels
                //monitorAudioLevels(stream);

                // Start the timer
                startTimer(10 * 60); // 10 minutes in seconds

            } catch (err) {
                permissionDeniedCount++;
                const errorMessage = document.getElementById('errorMessage');
                errorMessage.textContent = 'Permission denied or an error occurred: ' + err.message;
                document.getElementById('errorBox').classList.remove('hidden');

                if (permissionDeniedCount >= 3) {
                    document.getElementById('manualEnableBox').classList.remove('hidden');
                    document.getElementById('grantPermissionBtn').disabled = true;
                }
            }
        });


        document.getElementById('termsCheckbox').addEventListener('change', function() {
            const nextBtn = document.getElementById('nextBtn');
            nextBtn.disabled = !this.checked;
        });

        document.getElementById('nextBtn').addEventListener('click', function() {
            document.getElementById('instructionsDiv').classList.add('hidden');
            document.getElementById('welcome-main').classList.add('hidden');
            document.getElementById('examInfo').classList.remove('hidden'); // Show the examInfo div
        });


        document.addEventListener('DOMContentLoaded', (event) => {

            $('#startExamBtn').on('click', function() {
                var userId = $(this).data('user-id');
                var examId = $(this).data('exam-id');

                $.ajax({
                    url: '/fetch-attempt',
                    method: 'POST',
                    data: {
                        user_id: userId,
                        exam_id: examId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Set the hidden input field with the attempt_id
                            $('#attempt_id').val(response.attempt_id);
                            $('#examTimer').text(response.time);
                            showExamPannel(response.attempt_id);
                        } else {
                            console.error('No attempt available');
                            alert("Unable to fetch the exam attempt. Please try again.");
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching or creating the exam attempt');
                        alert("An error occurred while fetching the exam attempt.");
                    }
                });
            });

            function showExamPannel(attempt_id) {
                const video = document.getElementById('video');
                document.getElementById('examInfo').classList.add('hidden');
                document.getElementById('examPannel').classList.remove('hidden');

                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then((stream) => {
                        video.srcObject = stream;
                    })
                    .catch((err) => {
                        console.error("Error accessing the camera: ", err);
                        alert("Error accessing the camera. Please allow camera access to proceed.");
                    });


                function updateTimer() {
                    let timePeriod = document.getElementById('examTimer').textContent.trim();
                    let parts = timePeriod.split(':');
                    let hours = parseInt(parts[0], 10);
                    let minutes = parseInt(parts[1], 10);
                    let seconds = parts.length > 2 ? parseInt(parts[2], 10) : 0; // Assume 0 seconds if not provided

                    // Decrement seconds
                    if (seconds > 0) {
                        seconds--;
                    } else if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else if (hours > 0) {
                        hours--;
                        minutes = 59;
                        seconds = 59;
                    } else {
                        clearInterval(timerInterval);
                        submitForm();
                        return;
                    }


                    if (hours === 0 && minutes === 1 && seconds === 0) {
                        showAlert("Last 1 minute left");
                    }

                    document.getElementById('examTimer').textContent =
                        String(hours).padStart(2, '0') + ':' +
                        String(minutes).padStart(2, '0') + ':' +
                        String(seconds).padStart(2, '0');
                }

                function saveCurrentTimeToDatabase(examAttemptId) {
                    // Get the current time from the examTimer element
                    let currentTime = document.getElementById('examTimer').innerText.trim();

                    // Send an AJAX request to save the current time to the database
                    $.ajax({
                        url: '/save-remaining-time', // Update this to your backend endpoint
                        method: 'POST',
                        data: {
                            exam_attempt_id: examAttemptId, // Pass the exam attempt ID
                            remainingTime: currentTime, // Send the current time as displayed (HH:MM or HH:MM:SS)
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Time saved successfully:', response);
                        },
                        error: function(error) {
                            console.log('Error saving time:', error);
                        }
                    });
                }

                // Set the interval to call updateTimer every second
                let timerInterval = setInterval(updateTimer, 1000); // Update every second
                let saveTimeInterval = setInterval(function() {
                    saveCurrentTimeToDatabase(attempt_id); // Replace with the actual examAttempt ID
                }, 1000);


            }


        });
    </script>

    <!--Script for clickable ans div-->
    <script>
        $(document).ready(function() {
            $('.choice-div').click(function() {
                // Find the input of type radio inside the clicked div
                var radioInput = $(this).find('input[type=radio]');

                // Check the radio button
                radioInput.prop('checked', true);

                // Optionally, you can trigger a change event if you need to perform additional actions
                radioInput.trigger('change');
            });
        });
    </script>

    <!--Script for prevent page reload-->
    <script>
        // Prevent specific key combinations that could reload the page
        document.addEventListener('keydown', function(event) {
            if ((event.key === 'F5') ||
                (event.ctrlKey && event.key === 'r') ||
                (event.ctrlKey && event.key === 'R') ||
                (event.ctrlKey && event.key === 'F5')) {
                event.preventDefault(); // Prevent F5, Ctrl+R, or Ctrl+F5 reloads
            }
        });
    </script>

    <!--Script for next/prev/mark buttons-->

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let currentIndex = 0;
            const questions = document.querySelectorAll('.question-item');
            const buttons = document.querySelectorAll(
                '#questionList .question-btn'); // Buttons in the question list
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const reviewButton = document.getElementById('reviewButton');
            const reviewStatus = new Array(questions.length).fill(false); // Track review status of questions

            // Function to show the selected question and highlight the active question button
            function showQuestion(index) {
                questions.forEach((q, i) => q.classList.toggle('hidden', i !== index)); // Show/Hide question
                updateButtonColors(); // Update the colors of question list buttons

                // Update the review button text and color based on review status
                updateReviewButton(index);

                prevButton.disabled = index === 0;
                nextButton.disabled = index === questions.length - 1;
            }

            // Function to update button colors in the question list
            function updateButtonColors() {
                buttons.forEach((btn, i) => {
                    if (i === currentIndex) {
                        btn.classList.add('border-2', 'border-blue-500'); // Active question - blue border
                    } else {
                        btn.classList.remove('border-2', 'border-blue-500'); // Remove border for non-active
                    }

                    // Set button colors based on answer and review status
                    if (reviewStatus[i]) {
                        btn.classList.add('bg-orange-500', 'text-white'); // Marked for review - orange
                        btn.classList.remove('bg-green-500', 'text-white', 'bg-white', 'text-gray-800');
                    } else if (isAnswerSelected(i + 1)) {
                        btn.classList.add('bg-green-500', 'text-white'); // Answered - green
                        btn.classList.remove('bg-orange-500', 'bg-white', 'text-gray-800');
                    } else {
                        btn.classList.add('bg-white', 'text-gray-800'); // Default - not answered
                        btn.classList.remove('bg-green-500', 'text-white', 'bg-orange-500');
                    }
                });
            }

            // Function to check if a question has been answered
            function isAnswerSelected(index) {
                return document.querySelector(`input[name="radio_${index}"]:checked`) !== null;
            }

            // Function to update review button state
            function updateReviewButton(index) {
                if (reviewStatus[index]) {
                    reviewButton.innerText = 'Unmark';
                    reviewButton.classList.add('bg-gray-400');
                    reviewButton.classList.remove('bg-orange-500');
                } else {
                    reviewButton.innerText = 'Mark for Review';
                    reviewButton.classList.add('bg-orange-500');
                    reviewButton.classList.remove('bg-gray-400');
                }
            }

            // Initialize the first question
            showQuestion(currentIndex);

            // Sidebar button click event to navigate to specific questions
            buttons.forEach((button, idx) => {
                button.addEventListener('click', () => {
                    currentIndex = idx;
                    showQuestion(currentIndex);
                });
            });

            // Next and Previous button event listeners
            prevButton.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    showQuestion(currentIndex);
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentIndex < questions.length - 1) {
                    currentIndex++;
                    showQuestion(currentIndex);
                }
            });

            // Review button click event to mark/unmark question for review
            reviewButton.addEventListener('click', () => {
                reviewStatus[currentIndex] = !reviewStatus[currentIndex]; // Toggle review status
                updateReviewButton(currentIndex); // Update review button for the current question
                updateButtonColors(); // Update question list button colors
            });

            // Radio input change event to detect answer selection
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    updateButtonColors(); // Update colors when an answer is selected
                });
            });
        });
    </script>


    <!--Final form submit Script-->
    <script>
        $(document).ready(function() {

            $('input[type=radio].select_ans').on('change', function() {
                var num = $(this).attr('data-id');
                $('#ans_' + num).val($(this).val());
            });


            const confirmationModal = document.getElementById('confirmationModal');
            const totalQuestionsSpan = document.getElementById('totalQuestions');
            const questionsAttendedSpan = document.getElementById('questionsAttended');
            const confirmSubmitBtn = document.getElementById('confirmSubmit');
            const cancelSubmitBtn = document.getElementById('cancelSubmit');
            const submitBtn = document.getElementById('examFormSubmit');

            const totalQuestions = $('input[name="q[]"]').length;


            // const countAnsweredQuestions = () => {
            //     let answeredQuestions = 0;

            //     $('input[id^="ans_"]').each(function() {
            //         if ($(this).val() !== "") {
            //             answeredQuestions++;
            //         }
            //     });

            //     return answeredQuestions;
            // };

            const countAnsweredQuestions = () => {
                let answeredQuestions = 0;

                // Loop through each radio input with name starting with 'radio_'
                $('input[name^="radio_"]').each(function() {
                    if ($(this).is(':checked')) { // Check if the radio button is checked
                        answeredQuestions++; // Increment the count for each checked radio button
                    }
                });

                return answeredQuestions;
            };


            $("#examForm").submit(function(e) {
                e.preventDefault();

                const answeredQuestions = countAnsweredQuestions();

                // Update the modal with the counts
                totalQuestionsSpan.textContent = totalQuestions;
                questionsAttendedSpan.textContent = answeredQuestions;

                // Show the modal
                confirmationModal.classList.remove('hidden');
            });

            // Confirm submission
            confirmSubmitBtn.addEventListener('click', function() {

                //const formData = new FormData(document.getElementById('examForm'));
                var attemptId = $('#attempt_id').val();
                confirmSubmitBtn.disabled = true;

                confirmSubmitBtn.innerText = "Submitting...";


                // Fetch API for form submission
                fetch("{{ route('examSubmit') }}", {
                        method: 'POST', // Use POST method
                        headers: {
                            'Content-Type': 'application/json', // Send JSON data
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                        },
                        body: JSON.stringify({
                            attempt_id: attemptId,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            location.reload();
                            window.location.href = "{{ route('thankYou') }}/" + data.examId;
                        } else {
                            alert(data.msg);
                            submitBtn.disabled = false;
                            submitBtn.innerText = "Submit";
                        }
                    })
                    .catch(error => {
                        console.error("Error submitting the form:", error);
                        alert("There was an error submitting the exam. Please try again.");
                        submitBtn.disabled = false;
                        submitBtn.innerText = "Submit";
                    });
            });

            // Cancel submission
            cancelSubmitBtn.addEventListener('click', function() {
                confirmationModal.classList.add('hidden'); // Hide modal
            });


        });
    </script>


    <!-- Script for camera access in examPannel -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('video');
            const cameraBox = document.getElementById('camera-box');
            const startExamBtn = document.getElementById('startExamBtn');
            const parentDiv = cameraBox.parentElement; // Get the parent div to calculate boundaries

            let isDragging = false;
            let offsetX, offsetY;

            cameraBox.addEventListener('mousedown', startDrag);
            cameraBox.addEventListener('touchstart', startDrag);
            document.addEventListener('mousemove', drag);
            document.addEventListener('touchmove', drag);
            document.addEventListener('mouseup', stopDrag);
            document.addEventListener('touchend', stopDrag);

            function startDrag(e) {
                isDragging = true;
                if (e.type === 'touchstart') {
                    offsetX = e.touches[0].clientX - cameraBox.offsetLeft;
                    offsetY = e.touches[0].clientY - cameraBox.offsetTop;
                } else {
                    offsetX = e.clientX - cameraBox.offsetLeft;
                    offsetY = e.clientY - cameraBox.offsetTop;
                }
                e.preventDefault(); // Prevent default behavior
            }

            function drag(e) {
                if (isDragging) {
                    let clientX, clientY;
                    if (e.type === 'touchmove') {
                        clientX = e.touches[0].clientX;
                        clientY = e.touches[0].clientY;
                    } else {
                        clientX = e.clientX;
                        clientY = e.clientY;
                    }

                    // Get the boundaries of the parent div
                    const parentRect = parentDiv.getBoundingClientRect();
                    const cameraRect = cameraBox.getBoundingClientRect();

                    // Calculate new positions, making sure the cameraBox stays within the parent div
                    let newLeft = clientX - offsetX;
                    let newTop = clientY - offsetY;

                    // Boundaries: Prevent cameraBox from going outside parent div
                    if (newLeft < 0) newLeft = 0; // Left boundary
                    if (newTop < 0) newTop = 0; // Top boundary
                    if (newLeft + cameraRect.width > parentRect.width) {
                        newLeft = parentRect.width - cameraRect.width; // Right boundary
                    }
                    if (newTop + cameraRect.height > parentRect.height) {
                        newTop = parentRect.height - cameraRect.height; // Bottom boundary
                    }

                    // Apply new position
                    cameraBox.style.left = newLeft + 'px';
                    cameraBox.style.top = newTop + 'px';
                }
            }

            function stopDrag() {
                isDragging = false;
            }
        });
    </script>

    <!-- form submit function -->
    <script>
        function submitForm() {

            var formData = $('#examForm').serialize();

            $.ajax({
                url: "{{ route('examSubmit') }}",
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.success == true) {
                        location.reload();

                        window.location.href = "{{ route('thankYou') }}/" + data.examId;
                    } else {
                        alert(data.msg);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    </script>

    <!--Full Screen Script-->
    <script>
        document.body.addEventListener('click', function() {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        });


        window.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
    </script>

    <script>
        document.addEventListener('fullscreenchange', function() {
            if (!document.fullscreenElement) {

            }
        });
    </script>

    <script>
        // document.addEventListener('visibilitychange', function() {
        //     if (document.hidden) {
        //         alert('Your tab changed');
        //         submitForm();
        //     }
        // });
    </script>


    <!--Script for disable right click and key down-->
    {{-- <script>
        document.addEventListener('keydown', function(event) {
            // F12 or Ctrl+Shift+I (Cmd+Option+I on mac)
            if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I') ||
                (event.metaKey && event.altKey && event.key === 'I')) {
                event.preventDefault();
            }

            // Prevent Ctrl+Shift+C (Cmd+Option+C on mac)
            if ((event.ctrlKey && event.shiftKey && event.key === 'C') ||
                (event.metaKey && event.altKey && event.key === 'C')) {
                event.preventDefault();
            }

            if (event.key === 'Escape') {
                event.preventDefault();
            }

        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('input[type="radio"]').on('change', function() {
                var attemptId = $('#attempt_id').val();
                var questionId = $(this).data('question-id'); // Get question id from data attribute
                var answerId = $(this).val(); // Get the selected answer
                var qCount = $(this).data('qcount'); // Get the current question number

                // Update hidden input field with the selected answer for this question
                $('#ans_' + qCount).val(answerId);

                // Send AJAX request to save the selected answer
                $.ajax({
                    url: '/save-attempt', // Adjust this to your route
                    method: 'POST',
                    data: {
                        attempt_id: attemptId,
                        question_id: questionId,
                        answer_id: answerId,
                        _token: '{{ csrf_token() }}' // Include CSRF token if you're using Laravel
                    },
                    success: function(response) {
                        console.log('Answer saved successfully');
                    },
                    error: function(jqXHR, textStatus) {
                        if (textStatus === 'error' || textStatus === 'timeout') {
                            // Show a popup when the request fails due to lost connection
                            alert("Internet connection lost. Please check your network.");
                        }
                    }
                });
            });
        });
    </script>

<script>
    // Function to handle when the user goes offline
function handleOffline() {
    alert("You have lost internet connection. Please check your network.");
    // Additional logic like pausing the exam can go here
}

// Function to handle when the user comes back online
function handleOnline() {
    alert("You are back online!");
    // Resume any actions that were paused due to connectivity issues
}

// Add event listeners for connection changes
window.addEventListener('offline', handleOffline);
window.addEventListener('online', handleOnline);

// Initial check if the user is online when the page loads
if (!navigator.onLine) {
    handleOffline();
}

    </script>

</body>

</html>
