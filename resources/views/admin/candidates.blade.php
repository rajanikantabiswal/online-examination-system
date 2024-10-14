@extends('layout/admin-layout')
@section('space-work')
    <div class="relative w-full h-full p-6 ">

        <div class="relative flex flex-col w-full h-full min-w-0 mb-6 break-words bg-white shadow-md ">
            <div class="px-4 py-3 mb-0 border-0 rounded-t">
                <div class="flex flex-wrap items-center">
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4">
                        <h3 class="text-2xl font-semibold text-blueGray-700 ">Candidates</h3>
                    </div>
                    <div class="relative flex-1 flex-grow w-full max-w-full px-4 text-right">
                        <button onclick="openModal('addCandidateModal')"
                            class="px-6 py-3 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded outline-none active:bg-indigo-600 focus:outline-none"
                            type="button">Add</button>
                        <button onclick="openModal('importCandidateModal')"
                            class="px-6 py-3 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-green-400 rounded outline-none active:bg-green-500 focus:outline-none"
                            type="button">Import</button>
                    </div>
                </div>
            </div>
            <div class="block w-full overflow-x-auto px-2">
                @if ($candidates->count() > 0)
                    @php
                        $slno = 1;
                    @endphp

                    <table id="candidate-search-table">
                        <thead>
                            <tr>
                                <th>
                                    <span class="flex items-center">
                                        #
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Name
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Email
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
                            @foreach ($candidates as $candidate)
                                <tr>
                                    <td class="font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $slno }}</td>
                                    <td>{{ $candidate->name }}</td>
                                    <td>{{ $candidate->email }}</td>

                                    <td class="text-2xl text-blue-600"><i class="ri-edit-box-line editBtn"
                                            data-id="{{ $candidate->id }}" onclick="openModal('editCandidateModal')"></i>
                                    </td>
                                    <td class="text-2xl text-blue-600"><i class="ri-delete-bin-line deleteBtn"
                                            data-id="{{ $candidate->id }}" onclick="openModal('deleteCandidateModal')"></i>
                                    </td>
                                </tr>

                                @php
                                    $slno++;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <h2 class="w-full mt-10 text-base font-semibold text-center ">No Candidate found!</h2>
                @endif
            </div>

        </div>


        <!--Candidate Modal-->
        <div id="addCandidateModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/3 ">
                    <form id="addCandidate">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Add Candidate</div>
                                <svg onclick="closeModal('addCandidateModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="flex flex-col w-full space-y-4">
                                <input
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('name') border border-red-500 @enderror"
                                    type="text" name="name" id="name" placeholder="Name" required />
                                <input
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('email') border border-red-500 @enderror"
                                    type="email" name="email" id="email" placeholder="Email ID" required />
                                <input
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('password') border border-red-500 @enderror"
                                    type="text" name="password" id="password" placeholder="Password" required />

                            </div>

                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('addCandidateModal')"
                                    class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button id="submitBtn" type="submit"
                                    class="px-6 py-2 font-bold text-white bg-blue-500 rounded disabled:opacity-50 hover:bg-blue-700">
                                    Save
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Edit Candidate Modal-->
        <div id="editCandidateModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/3 ">
                    <form id="editCandidate">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Edit Candidate</div>
                                <svg onclick="closeModal('editCandidateModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="flex flex-col w-full space-y-4">
                                <input type="hidden" name="id" id="edit_cand_id">
                                <input
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('name') border border-red-500 @enderror"
                                    type="text" name="name" id="edit_cand_name" placeholder="Name" required />
                                <input
                                    class="w-full  px-4 py-2 bg-gray-100  rounded-lg focus:outline-none @error('email') border border-red-500 @enderror"
                                    type="email" name="email" id="edit_cand_email" placeholder="Email ID" required />

                            </div>

                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('editCandidateModal')"
                                    class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button id="editSubmitBtn" type="submit"
                                    class="px-6 py-2 font-bold text-white bg-blue-500 rounded disabled:opacity-50 hover:bg-blue-700">
                                    Save
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Delete Candidate Modal-->
        <div id="deleteCandidateModal" class="hidden">
            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/3 ">
                    <form id="deleteCandidate">
                        @csrf
                        <div class="flex flex-col items-start gap-2 p-4">
                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Are you want to delete
                                    this?</div>
                                <svg onclick="closeModal('deleteCandidateModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="flex flex-col w-full space-y-4">
                                <input type="hidden" name="id" id="delete_cand_id">
                            </div>

                            <hr>
                            <div class="ml-auto">
                                <button type="button" onclick="closeModal('deleteCandidateModal')"
                                    class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-gray-500 hover:text-white hover:border-transparent">
                                    Close
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 font-bold text-white bg-blue-500 rounded disabled:opacity-50 hover:bg-blue-700">
                                    Delete
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div id="importCandidateModal" class="hidden">

            <div
                class="absolute top-0 left-0 flex items-center justify-center w-full h-full overflow-hidden bg-[#0000002b] -[#2a343fcf] ">
                <div class="w-[90%] bg-white rounded-lg lg:w-1/2 ">
                    <form id="importCandidate" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col items-start gap-1 p-4">

                            <div class="flex items-center w-full">
                                <div class="text-lg font-medium text-gray-900 ">Import Candidates</div>
                                <svg onclick="closeModal('importCandidateModal')"
                                    class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                    <path
                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                </svg>
                            </div>
                            <hr>

                            <div class="w-full">

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
                                    <button type="button" onclick="closeModal('importCandidateModal')"
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
        if (document.getElementById("candidate-search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#candidate-search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            // add candidate
            $("#addCandidate").submit(function(e) {
                e.preventDefault();
                var submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerText = "Adding..";
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addCandidate') }}",
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

            //edit candidate

            $(".editBtn").click(function() {
                var candidateId = $(this).attr('data-id');
                $("#edit_cand_id").val(candidateId);

                var url = '{{ route('getCandidateDetails', 'cId') }}';
                url = url.replace('cId', candidateId);

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(data) {
                        if (data.success == true) {
                            var candidate = data.data;
                            $("#edit_cand_name").val(candidate[0].name);
                            $("#edit_cand_email").val(candidate[0].email);
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            });

            $("#editCandidate").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('updateCandidate') }}",
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

            // delete candidate
            //edit candidate

            $(".deleteBtn").click(function() {
                var candidateId = $(this).attr('data-id');
                $("#delete_cand_id").val(candidateId);


            });

            $("#deleteCandidate").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteCandidate') }}",
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


            //import Candidates
            $("#importCandidate").submit(function(e) {
                e.preventDefault();
                let importBtn = document.getElementById('importBtn');
                importBtn.disabled = true; // Disable the button to prevent multiple submissions
                importBtn.textContent = 'Importing...'; // Optionally change the button text

                let formData = new FormData();
                formData.append("file", $("#fileUpload")[0].files[0]);

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
                            $('#importCandidateModal').addClass('hidden');
                            $('#candidatesExists').text(data.existingUsers);
                            $('#candidatesCreated').text(data.newUsers);
                            $('#importResponseModal').removeClass('hidden');

                        } else {
                            alert(data.msg);
                        }

                    }
                });
            });
        });
    </script>

@endsection
