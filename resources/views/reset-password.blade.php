@extends('layout/layout-common')

@section('space-work')
    <div class="flex items-center justify-center h-screen bg-indigo-100">
        <div class="w-2/3 lg:w-1/3">
            <form action="{{ route('resetPassword') }}" method="POST"
                class="min-w-full p-10 bg-white rounded-lg shadow-lg">
                @csrf
                <h1 class="mb-6 font-sans text-2xl font-bold text-center text-gray-600">Reset Password</h1>
                
                    <input type="hidden" name="id"
                        id="username" value="{{$user->id}}" />
                <div>
                    <label class="block my-3 font-semibold text-gray-800 text-md" for="password">Password</label>
                    <input class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none @error('password') border border-red-500 @enderror" type="text" name="password"
                        id="password" placeholder="password" />
                        @error('password')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block my-3 font-semibold text-gray-800 text-md" for="confirm">Confirm password</label>
                    <input class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none" type="text"
                        name="password_confirmation" id="confirm" placeholder="confirm password" />
                </div>
                <button type="submit"
                    class="w-full px-4 py-2 mt-6 font-sans text-lg font-semibold tracking-wide text-white bg-indigo-600 rounded-lg">Reset Password</button>
                    
            </form>
        </div>
    </div>
@endsection
