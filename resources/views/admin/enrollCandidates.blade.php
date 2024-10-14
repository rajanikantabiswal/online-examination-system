@extends('layout/admin-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">
            <div class="px-4 py-3 mb-0 border-0 rounded-t">
                <div class="flex flex-wrap items-center">
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                        <h3 class="text-2xl font-semibold text-blueGray-700 ">{{ $exam->exam_name }}</h3>
                    </div>

                </div>
            </div>

            <div class="block w-full overflow-x-auto">
                <form action="{{ route('exams.enrollCandidatesToExam') }}" method="POST">
                    @csrf
                    <div class="p-4">
                        <input type="hidden" name="examId" value="{{ $exam->id }}">
                        <table class="table-auto min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-2">Select</th>
                                    <th class="text-left py-3 px-2">Name</th>
                                    <th class="text-left py-3 px-2">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $candidate)
                                    <tr class="border-b">
                                        <td class="text-left py-3 px-2">
                                            <input type="checkbox" name="candidate_ids[]" value="{{ $candidate->id }}"
                                                class="form-checkbox h-5 w-5 text-gray-600"
                                                id="filter-option-{{ $candidate->id }}"
                                                {{ in_array($candidate->id, $assignedCandidates) ? 'checked' : '' }} />
                                        </td>
                                        <td class="text-left py-3 px-2">{{ $candidate->name }}</td>
                                        <td class="text-left py-3 px-2">{{ $candidate->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="flex gap-2 py-2">
                            <button onclick="openModal('examCandidateImport')" type="button"
                                class="bg-green-500 py-2 px-6 rounded text-white font-semibold">Add
                                Candidate</button>
                            <button type="submit"
                                class="bg-blue-500 py-2 px-6 rounded text-white font-semibold">Enroll</button>
                        </div>

                    </div>
                </form>


            </div>
        </div>

        <!-- import qna modal -->
        <div id="examCandidateImport" class="hidden">

            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/2 ">
                    <form id="examCandidateImportForm" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col items-start gap-1 p-4">

                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Add Candidates</div>
                                <svg onclick="closeModal('examCandidateImport')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="w-full">

                                <input type="hidden" name="import_examId" value="{{ $exam->id }}">
                                <input type="file" id="fileUpload" name="file"
                                    class="w-full overflow-clip rounded-xl border border-slate-300 bg-slate-100/50 text-sm text-slate-700 file:mr-4 file:cursor-pointer file:border-none file:bg-slate-100 file:px-4 file:py-2 file:font-medium file:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700 disabled:cursor-not-allowed disabled:opacity-75"
                                    required
                                    accept=".csv, application/vnd.ms.excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                            </div>
                            <hr>
                            <div class="flex items-center justify-between w-full">
                                <a class="underline text-blue-500 font-semibold"
                                    href="{{ asset('samples/Sample-Candidate-Import-Format.xlsx') }}">Download Import
                                    Format</a>
                                <div class="">
                                    <button type="button" onclick="closeModal('examCandidateImport')"
                                        class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                        Close
                                    </button>
                                    <button id="importBtn" type="submit"
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

    <div id="importResponseModal"
        class="hidden fixed z-50 top-0 left-0 w-full h-full flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-4 rounded shadow-lg min-w-[50vw]">
            <h2 class="text-lg font-bold mb-2">Imported successfully</h2>
            <p><span id="candidatesExists"></span> candidates exist in the system.</p>
            <p><span id="candidatesCreated"></span> new candidates were successfully created</p>
            <div class="mt-4 flex justify-end">
                <button onclick="location.reload();" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>

    <script>
        //import Candidates
        $("#examCandidateImportForm").submit(function(e) {
            e.preventDefault();
            let importBtn = document.getElementById('importBtn');
            importBtn.disabled = true; // Disable the button to prevent multiple submissions
            importBtn.textContent = 'Importing...'; // Optionally change the button text

            let formData = new FormData(this);
            // formData.append("file", $("#fileUpload")[0].files[0]);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            });

            $.ajax({
                url: "{{ route('importCandidate') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success == true) {
                        $('#examCandidateImport').addClass('hidden');
                        $('#candidatesExists').text(data.existingUsers);
                        $('#candidatesCreated').text(data.newUsers);
                        $('#importResponseModal').removeClass('hidden');

                    } else {
                        alert(data.msg);
                    }

                }
            });
        });
    </script>
@endsection
