@extends('layout/layout-common')

@section('space-work')
    <div class="flex items-center justify-center h-screen bg-indigo-100">
        @if (Session::has('success'))
            <!-- component -->
            <!-- Global notification live region, render this permanently at the end of the document -->
            <div id="alertBox" aria-live="assertive"
                class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:items-start sm:p-6">
                <div class="flex flex-col items-center w-full space-y-4 sm:items-end">
                    <!--
                Notification panel, dynamically insert this into the live region when it needs to be displayed
          
                Entering: "transform ease-out duration-300 transition"
                  From: "translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                  To: "translate-y-0 opacity-100 sm:translate-x-0"
                Leaving: "transition ease-in duration-100"
                  From: "opacity-100"
                  To: "opacity-0"
              -->
                    <div
                        class="w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium text-gray-900">Email sent successfylly!</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ Session::get('success') }}</p>
                                </div>
                                <div class="flex flex-shrink-0 ml-4">
                                    <button type="button" onclick="closeAlertBox()"
                                        class="inline-flex text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="w-2/3 lg:w-1/3">
            <form action="{{ route('forgotPassword') }}" method="POST"
                class="min-w-full p-10 bg-white rounded-lg shadow-lg">
                @csrf
                <h1 class="mb-6 font-sans text-2xl font-bold text-center text-gray-600">Forgot Password</h1>
                
                <div>
                    <label class="block my-3 font-semibold text-gray-800 text-md" for="email">Email</label>
                    <input
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none @error('email') border border-red-500 @enderror"
                        type="text" name="email" id="email" placeholder="@email" value="{{ old('email') }}" />
                        @error('email')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                    
                        <div class="text-red-600">{{ Session::get('error') }}</div>
                </div>
                
                
                <button type="submit" class="w-full px-4 py-2 mt-6 font-sans text-lg font-semibold tracking-wide text-white bg-indigo-600 rounded-lg">Forgot Password</button>
                    <div class="text-center">
                        <a href="/login" class="text-blue-500 hover:underline">Login again</a>
                    </div>

            </form>

            
        </div>
    </div>
@endsection
