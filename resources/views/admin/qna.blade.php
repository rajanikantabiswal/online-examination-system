@extends('layout/admin-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">
            <div class="px-4 py-3 mb-0 border-0 rounded-t">
                <div class="flex flex-wrap items-center">
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                        <h3 class="text-2xl font-semibold text-blueGray-700 ">{{ $exams[0]->exam_name }}</h3>
                    </div>
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4 text-right">
                        <button onclick="openModal('addQnaModal')"
                            class="px-6 py-3 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded outline-none active:bg-indigo-600 focus:outline-none"
                            type="button">Add Question</button>
                        <button onclick="openModal('importQnaMOdal')"
                            class="px-6 py-3 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-green-400 rounded outline-none active:bg-green-500 focus:outline-none"
                            type="button">Import Q & A</button>
                    </div>
                </div>
            </div>
            <div class="block w-full overflow-x-auto">
                @if ($questions->count() > 0)
                    @php
                        $slno = 1;
                    @endphp


                    <table class="w-full bg-transparent border-collapse ">

                        <thead class="">
                            <tr>
                                <th
                                    class="w-[5%] px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    #
                                </th>
                                <th
                                    class="w-[80%] px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Questions
                                </th>

                                <th
                                    class="w-[5%] px-6 py-3 font-semibold text-left uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Answers
                                </th>
                                <th
                                    class="w-[5%] px-6 py-3 font-semibold text-center uppercase align-middle border border-l-0 border-r-0 border-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Edit
                                </th>
                                <th
                                    class="w-[5%] px-6 py-3 font-semibold text-center uppercase align-middle border border-l-0 border-r-0 bordeer-solid text-md bg-blueGray-50 text-blueGray-500 border-blueGray-100 whitespace-nowrap ">
                                    Delete
                                </th>

                            </tr>
                        </thead>


                        @foreach ($questions as $question)
                            <tbody>
                                <tr>
                                    <th
                                        class="w-[5%] p-4 px-6 text-base text-left align-top border-t-0 border-l-0 border-r-0 whitespace-nowrap text-blueGray-700 ">
                                        {{ $slno }}
                                    </th>
                                    <td
                                        class="w-[80%] p-4 px-6 text-base whitespace-normal align-middle border-t-0 border-l-0 border-r-0 ">
                                        <div class="prose font-semibold">{!! $question->question !!}</div>
                                    </td>

                                    <td
                                        class="w-[5%] p-4 px-6 text-2xl text-left text-blue-500 border-t-0 border-l-0 border-r-0 whitespace-nowrap">

                                        <i class=" ri-eye-line ansBtn" data-id="{{ $question->id }}"
                                            onclick="openModal('ansModal')"></i>
                                    </td>
                                    <td
                                        class="w-[5%] p-4 px-6 text-2xl text-center text-blue-500 border-t-0 border-l-0 border-r-0 align-center whitespace-nowrap">
                                        <i class="ri-edit-box-line editBtn" data-id="{{ $question->id }}"
                                            onclick="openModal('editQnaModal')"></i>
                                    </td>

                                    <td
                                        class="w-[5%] p-4 px-6 text-2xl text-center text-blue-500 align-middle border-t-0 border-l-0 border-r-0 whitespace-nowrap">
                                        <i class="ri-delete-bin-line deleteBtn" data-id="{{ $question->id }}"
                                            onclick="openModal('deleteQnaModal')"></i>
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


        <!--Add Qna Modal-->
        <div id="addQnaModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-scroll bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-3/5 ">
                    <form id="addQna">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Add Question</div>
                                <svg onclick="closeModal('addQnaModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="flex flex-col w-full space-y-4 questionBox">
                                <input type="hidden" name="examId" value="{{ $exams[0]->id }}">
                                <div id="content">
                                    Write your question here..

                                </div>
                                <textarea hidden
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('exam') border border-red-500 @enderror"
                                    name="question" id="question" placeholder="Write your question here.."></textarea>
                                <div class="flex flex-col w-full space-y-2 mcqBox ">

                                </div>
                            </div>
                            <button id="addAnswer" type="button" class="px-6 py-2 text-white bg-blue-500 rounded">Add
                                Answer</button>


                            <hr>
                            <span class="text-left text-red-500 error"></span>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('addQnaModal')"
                                    class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Save
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Qna Modal-->
        <div id="editQnaModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-scroll bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-3/5 ">
                    <form id="editQna">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Update Question</div>
                                <svg onclick="closeModal('editQnaModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="flex flex-col w-full space-y-4 editQuestionBox">
                                <input type="hidden" name="question_id" id="question_id">
                                <div id="editContent">
                                    Write your question here..
                                </div>
                                <textarea hidden
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('exam') border border-red-500 @enderror"
                                    name="question" id="editQuestion" placeholder="Write your question here.."></textarea>
                                <div class="flex flex-col w-full space-y-2 editMcqBox">
                                </div>

                            </div>
                            <button id="addEditAnswer" type="button" class="px-6 py-2 text-white bg-blue-500 rounded">Add
                                Answer</button>


                            <hr>
                            <span class="text-left text-red-500 editError"></span>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('editQnaModal')"
                                    class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Update
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--Delete Qna Modal-->
        <div id="deleteQnaModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-1/3 bg-white rounded-lg ">
                    <form id="deleteQna">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Are you want to delete
                                    this question?</div>
                                <svg onclick="closeModal('deleteQnaModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>
                            <div class="w-full">
                                <input type="hidden" id="deleteQnaId" name="id">
                            </div>
                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('deleteQnaModal')"
                                    class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Delete
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- show ans modal -->
        <div id="ansModal" class="hidden">

            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/3 ">

                    <div class="flex flex-col items-start gap-1 p-4">
                        <div class="flex items-center w-full">
                            {{-- <div class="text-lg font-medium text-gray-900 ">Answers</div> --}}
                            <svg onclick="closeModal('ansModal')"
                                class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                            </svg>
                        </div>
                        <hr>

                        <div class="w-full">
                            <table class="items-center w-full bg-transparent border-collapse  answerBox">

                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>


        <!-- import qna modal -->
        <div id="importQnaMOdal" class="hidden">

            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/3 ">
                    <form id="importQna" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col items-start gap-1 p-4">

                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Import Questions</div>
                                <svg onclick="closeModal('importQnaMOdal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>

                            <hr>

                            <div class="w-full">
                                <input type="hidden" name="examId" value="{{ $exams[0]->id }}">

                                <input type="file" id="fileUpload" name="file"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-blue-500 hover:file:bg-violet-100 "
                                    required
                                    accept=".csv, application/vnd.ms.excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                            </div>
                            <hr>
                            <span class="text-left text-red-500 error"></span>
                            <div class="flex items-center justify-between w-full">
                                <a class="underline text-blue-500 font-semibold"
                                    href="{{ asset('samples/Sample-Question-Import-Format.xlsx') }}">Download Import
                                    Format</a>
                                <div>
                                    <button type="button" onclick="closeModal('importQnaMOdal')"
                                        class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                        Close
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                        Import
                                    </button>
                                </div>


                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        const quill = new Quill('#content', {
            modules: {
                toolbar: [
                    ['bold', 'italic'],
                    ['link', 'blockquote', 'code-block', 'image'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                ],
            },
            theme: 'snow',
        });

        const editQuill = new Quill('#editContent', {
            modules: {
                toolbar: [
                    ['bold', 'italic'],
                    ['link', 'blockquote', 'code-block', 'image'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                ],
            },
            theme: 'snow',
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#addQna").submit(function(e) {
                e.preventDefault();
                var content = document.querySelector('#question');
                content.value = quill.root.innerHTML;


                if ($(".answers").length < 2) {
                    $(".error").text("Please add minimum two answers.")
                    setTimeout(() => {
                        $(".error").text("");
                    }, 2500);
                } else {

                    var checkIsCorrect = false;

                    for (let i = 0; i < $(".is_correct").length; i++) {
                        if ($(".is_correct:eq(" + i + ")").prop('checked') == true) {
                            checkIsCorrect = true;
                            $(".is_correct:eq(" + i + ")").val($(".is_correct:eq(" + i + ")").next().val())
                        }
                    }

                    if (checkIsCorrect) {

                        var formdata = $(this).serialize();

                        $.ajax({
                            url: "{{ route('addQna') }}",
                            type: "POST",
                            data: formdata,
                            success: function(data) {
                                
                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    alert(data.m);
                                }
                            }
                        });

                    } else {
                        $(".error").text("Please select anyone correct answer")
                        setTimeout(() => {
                            $(".error").text("");
                        }, 2500);
                    }
                }


            });


            //add answer
            $("#addAnswer").click(function() {
                if ($(".answers").length >= 6) {
                    $(".error").text("You can add maximum 6 choices.")
                    setTimeout(() => {
                        $(".error").text("");
                    }, 2500);
                } else {
                    var html = `
                <div class="flex items-center w-full gap-2 answers">
                                        <input type="radio" name="is_correct" class="w-5 h-5 border-4 border-blue-300 is_correct focus:ring-2 focus:ring-blue-300">
                                        <input type="text" name="answers[]" placeholder="Enter ansewe here" class="w-1/2 px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none" required>
                                        <button type="button" class="px-4 py-2 text-white bg-red-500 rounded-lg removeBtn">Remove</button>
                                    </div>
                `;
                    $(".mcqBox").append(html);
                }

            });


            //add Edit answer
            $("#addEditAnswer").click(function() {
                if ($(".editAnswers").length >= 6) {
                    $(".editError").text("You can add maximum 6 choices.")
                    setTimeout(() => {
                        $(".editError").text("");
                    }, 2500);
                } else {
                    var html = `
                <div class="flex items-center w-full gap-2 editAnswers">
                                        <input type="radio" name="is_correct" class="w-5 h-5 border-4 border-blue-300 edit_is_correct focus:ring-2 focus:ring-blue-300">
                                        <input type="text" name="new_answers[]" placeholder="Enter ansewe here" class="w-1/2 px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none" required>
                                        <button type="button" class="px-4 py-2 text-white bg-red-500 rounded-lg removeBtn">Remove</button>
                                    </div>
                `;
                    $(".editMcqBox").append(html);
                }

            });

            $(document).on("click", ".removeBtn", function() {
                $(this).parent().remove();
            });


            //show answer
            $(".ansBtn").click(function() {
                var questions = @json($questions);
                var qId = $(this).attr('data-id');
                var html = '';

                for (let i = 0; i < questions.length; i++) {

                    if (questions[i]['id'] == qId) {
                        var answersLenght = questions[i]['answers'].length;

                        for (let j = 0; j < answersLenght; j++) {
                            let is_correct = "";
                            if (questions[i]['answers'][j]['is_correct'] == 1) {
                                is_correct =
                                    '<span class="px-3 py-1 font-semibold text-white bg-green-500 rounded">Ture</span>';
                            }
                            html +=
                                `
                                <tr class="border-2 ">
                                    <td class="px-6 py-2 text-base text-left align-middle text-blueGray-700 ">` +
                                questions[i]['answers'][j]['answer'] +
                                `</td>
                                    <td class="px-6 py-2 text-base text-right align-middle whitespace-nowrap ">` +
                                is_correct +
                                `</td>
                                </tr>
                            
                            `;
                        }
                        break;
                    }
                }

                $('.answerBox').html(html);

            });

            //import Q & A
            $("#importQna").submit(function(e) {
                e.preventDefault();


                let formData = new FormData(this);
                // formData.append("file", $("#fileUpload")[0].files[0]);

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: "{{ route('importQna') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();

                        } else {
                            alert(data.msg);
                        }

                    }
                });

            });




            //edit Q & A
            $(".editBtn").click(function() {
                var qid = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('getQnaDetails') }}",
                    type: "GET",
                    data: {
                        qid: qid
                    },
                    success: function(data) {
                       
                        var qna = data.data[0];
                        $("#question_id").val(qna['id']);
                        // $("#editQuestion").val(qna['question']);
                        editQuill.root.innerHTML = qna['question'];

                        var html = "";
                        for (let i = 0; i < qna['answers'].length; i++) {
                            var checked = '';
                            if (qna['answers'][i]['is_correct'] == 1) {
                                checked = 'checked';
                            }
                            html +=
                                `
                            <div class="flex items-center w-full gap-2 editAnswers">
                                        <input type="radio" name="is_correct" class="w-5 h-5 border-4 border-blue-300 edit_is_correct focus:ring-2 focus:ring-blue-300" ` +
                                checked + `>
                                        <input type="text" name="answers[` + qna['answers'][i]['id'] +
                                `]" placeholder="Enter ansewe here" class="w-1/2 px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none" value="` +
                                qna['answers'][i]['answer'] +
                                `"  required>
                                        <button type="button" class="px-4 py-2 text-white bg-red-500 rounded-lg removeBtn removeAnswer" data-id=` +
                                qna['answers'][i]['id'] +
                                `>Remove</button>
                                    </div>

                            `;
                        }

                        $(".editMcqBox").html(html);
                    }
                })
            });



            //update QnA
            $("#editQna").submit(function(e) {
                e.preventDefault();

                var content = document.querySelector('#editQuestion');
                content.value = editQuill.root.innerHTML;

                if ($(".editAnswers").length < 2) {
                    $(".editError").text("Please add minimum two answers.")
                    setTimeout(() => {
                        $(".editError").text("");
                    }, 2500);
                } else {

                    var checkIsCorrect = false;

                    for (let i = 0; i < $(".edit_is_correct").length; i++) {
                        if ($(".edit_is_correct:eq(" + i + ")").prop('checked') == true) {
                            checkIsCorrect = true;
                            $(".edit_is_correct:eq(" + i + ")").val($(".edit_is_correct:eq(" + i + ")")
                                .next().val())
                        }
                    }

                    if (checkIsCorrect) {

                        var formdata = $(this).serialize();

                        $.ajax({
                            url: "{{ route('updateQna') }}",
                            type: "POST",
                            data: formdata,
                            success: function(data) {
                                
                                if (data.success == true) {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            }
                        });

                    } else {
                        $(".editError").text("Please select anyone correct answer")
                        setTimeout(() => {
                            $(".editError").text("");
                        }, 2500);
                    }
                }


            });

            //delete Answer
            $(document).on('click', '.removeAnswer', function() {
                var ansId = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('deleteAnswer') }}",
                    type: "GET",
                    data: {
                        id: ansId
                    },
                    success: function(data) {
                        if (data.success == true) {
                            // location.reload();
                            
                        } else {
                            alert(data.msg);
                        }
                    }
                })

            });



            //delete exam

            $(".deleteBtn").click(function() {
                var question_id = $(this).attr('data-id');
                $("#deleteQnaId").val(question_id);
            });

            $("#deleteQna").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteQna') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }

                    }
                });
            });

        });
    </script>
@endsection
