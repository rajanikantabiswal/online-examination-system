@extends('layout/admin-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">
            <div class="px-4 py-3 mb-0 border-0 rounded-t">
                <div class="flex flex-wrap items-center">
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                        <h3 class="text-2xl font-semibold text-indigoGray-700 ">Exams</h3>
                    </div>
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4 text-right">
                        <button onclick="openModal('addExamModal')"
                            class="px-6 py-3 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded outline-none active:bg-indigo-600 focus:outline-none"
                            type="button">Add Exam</button>
                    </div>
                </div>
            </div>
            <div class="block w-full overflow-x-auto p-2">
                @if ($exams->count() > 0)
                    
                    <table id="search-table">
                        <thead>
                            <tr>
                                <th>
                                    <span class="flex items-center">
                                        Exam Name
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Time
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Questions
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Enrolled
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Status
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Edit
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Delete
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>
                                    <td class="font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $exam->exam_name }}</td>
                                    <td>{{ $exam->time }} Hrs</td>
                                    <td class="text-indigo-600"><a href="{{ route('exams') }}/{{ $exam->id }}"
                                            class="flex items-center gap-2"><i class="ri-eye-line text-2xl"></i><span
                                                class="text-md">({{ $exam->questions->count() }} Questions)</span></a></td>
                                    <td class="text-indigo-600"><a href="{{ route('exams.enrollStudents', $exam->id) }}"
                                        class="flex items-center gap-2"><i class="ri-eye-line text-2xl"></i><span
                                            class="text-md">({{ $exam->users->count() }} Candidates)</span></a></td>
                                    <td><label class="inline-flex items-center cursor-pointer">
                                        <input id="toggle-status" type="checkbox" class="sr-only peer toggle-status"
                                            data-id="{{ $exam->id }}"
                                            @if ($exam->is_active) @checked(true) @endif>
                                        <div
                                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 :ring-indigo-800 rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-indigo-600">
                                        </div>

                                    </label></td>
                                    <td class="text-2xl text-indigo-600"><i class="ri-edit-box-line editBtn" data-id="{{ $exam->id }}"
                                        onclick="openModal('editExamModal')"></i></td>
                                    <td class="text-2xl text-indigo-600"><i class="ri-delete-bin-line deleteBtn" data-id="{{ $exam->id }}"
                                        onclick="openModal('deleteExamModal')"></i></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <h2 class="w-full mt-10 text-base font-semibold text-center ">No Exam Found!</h2>
                @endif

            </div>

        </div>


        <!--Add exam Modal-->
        <div id="addExamModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-1/3 bg-white rounded-lg ">
                    <form id="addExam">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Add Exam</div>
                                <svg onclick="closeModal('addExamModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>
                            <div class="flex flex-col w-full space-y-4">
                                <input
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('exam') border border-indigo-500 @enderror"
                                    type="text" name="exam" id="exam" placeholder="Exam Name" requiindigo />

                                {{-- <input
                                    class="w-full px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none"
                                    type="number" name="mark_per_que" placeholder="Mark per question" requiindigo> --}}
                                <input
                                    class="w-full px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none"
                                    type="number" name="passing_criteria" placeholder="Passing criteria(In percentage)"
                                    requiindigo>

                                <input
                                    class="w-full px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none"
                                    type="time" name="time" format>

                                <div class="flex items-center mb-4 gap-3">
                                    <label for="retake"
                                        class="ms-2 text-sm font-medium text-gray-900 ">Retake
                                        exam</label>
                                    <input id="retake" type="number" min="0" value="0" name="retake"
                                        class="text-indigo-600 w-[50px] h-[30px] bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 :ring-indigo-600  focus:ring-2  ">
                                    
                                </div>

                                <div class="flex items-center mb-4 gap-3">
                                    <label for="view-result-checkbox"
                                        class="ms-2 text-sm font-medium text-gray-900 ">View
                                        Result</label>
                                    <input id="view-result-checkbox" type="checkbox" value="1" name="view_result"
                                        class="w-5 h-5 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 :ring-indigo-600  focus:ring-2  ">
                                    
                                </div>

                            </div>

                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('addExamModal')"
                                    class="px-4 py-2 font-semibold text-indigo-700 bg-transparent border border-indigo-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                    Add
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!--Edit exam Modal-->
        <div id="editExamModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-1/3 bg-white rounded-lg ">
                    <form id="editExam">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Edit Exam</div>
                                <svg onclick="closeModal('editExamModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>
                            <div class="flex flex-col w-full space-y-4">
                                <input type="hidden" id="exam_id" name="exam_id" />
                                <div>
                                    <label for="exam_name" class="  text-md">Exam Name:</label>
                                    <input
                                        class="w-full  mt-1 px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('exam') border border-indigo-500 @enderror"
                                        type="text" name="exam_name" id="exam_name" placeholder="Exam Name"
                                        requiindigo />
                                </div>
                                {{-- <div>
                                    <label for="mark_per_que" class="  text-md">Mark per question:</label>
                                    <input
                                        class="w-full px-4 py-2 mt-1 bg-gray-100 rounded-lg   focus:outline-none"
                                        type="number" name="mark_per_que" id="mark_per_que">
                                </div> --}}

                                <div>
                                    <label for="passing_criteria" class="  text-md">Passing criteria(In
                                        Percentage):</label>
                                    <input
                                        class="w-full px-4 py-2 mt-1 bg-gray-100 rounded-lg   focus:outline-none"
                                        type="number" name="passing_criteria" id="passing_criteria">
                                </div>
                                <div>
                                    <label for="time" class="  text-md">Duration:</label>
                                    <input
                                        class="w-full px-4 py-2 bg-gray-100 rounded-lg   focus:outline-none"
                                        type="time" name="time" id="time">
                                </div>

                                <div class="flex items-center mb-4 gap-3">
                                    <label for="edit_retake"
                                        class="ms-2 text-sm font-medium text-gray-900 ">Retake
                                        exam</label>
                                    <input id="edit_retake" type="number" min="0" name="retake"
                                        class="text-indigo-600 w-[50px] h-[30px] bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 :ring-indigo-600  focus:ring-2 ">
                                    
                                </div>

                                <div class="flex items-center mb-4">
                                    <input id="edit-view-result-checkbox" type="checkbox" name="view_result"
                                        value=""
                                        class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 :ring-indigo-600  focus:ring-2  ">
                                    <label for="edit-view-result-checkbox"
                                        class="ms-2 text-sm font-medium text-gray-900 ">View
                                        Result</label>
                                </div>



                            </div>
                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('editExamModal')"
                                    class="px-4 py-2 font-semibold text-indigo-700 bg-transparent border border-indigo-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                    Update
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Delete exam Modal-->
        <div id="deleteExamModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-1/3 bg-white rounded-lg ">
                    <form id="deleteExam">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Are you want to delete
                                    this?</div>
                                <svg onclick="closeModal('deleteExamModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>
                            <div class="w-full">
                                <input type="hidden" id="deleteExamId" name="id">
                            </div>
                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('deleteExamModal')"
                                    class="px-4 py-2 font-semibold text-indigo-700 bg-transparent border border-indigo-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                                    Delete
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            //add exam
            $("#addExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addExam') }}",
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

            //edit exam

            $(".editBtn").click(function() {
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);

                var url = '{{ route('getExamDetails', 'id') }}';
                url = url.replace('id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (data.success == true) {
                            var exam = data.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#time").val(exam[0].time);
                            $("#mark_per_que").val(exam[0].mark_per_que);
                            $("#passing_criteria").val(exam[0].passing_criteria);
                            $("#edit_retake").val(exam[0].retake);
                            $("#edit-view-result-checkbox").prop('checked', exam[0]
                                .view_result == 1);
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            });

            $("#editExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('updateExam') }}",
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

            //delete exam

            $(".deleteBtn").click(function() {
                var delete_exam_id = $(this).attr('data-id');
                $("#deleteExamId").val(delete_exam_id);
            });

            $("#deleteExam").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteExam') }}",
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

            //Active or deactive exam

            $('.toggle-status').change(function() {
                var exam_id = $(this).attr('data-id');
                var isActive = $(this).is(':checked') ? 1 : 0;
                

                $.ajax({
                    url: "{{ route('toggleExamStatus') }}",
                    type: 'POST',
                    data: {
                        examId: exam_id,
                        is_active: isActive,
                        _token: '{{ csrf_token() }}' // Include the CSRF token
                    },
                    success: function(data) {
                        if (data.success == true) {
                            // location.reload();
                            
                        } else {
                            alert(data.msg);
                        }

                    }
                });
            });

        });
    </script>

@endsection
