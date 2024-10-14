@extends('layout.layout-common')
@section('space-work')

        <div class="flex flex-col items-center min-h-screen pt-20 space-y-10">
            <h2 class="mt-10 text-3xl text-center text-green-700 lg:text-5xl">Your exam submitted successfully</h2>
            <div>
                @can('view-result', $exam_id)
                <a href="/result-dashboard/{{$exam_id}}" class="px-6 py-2 text-white bg-green-700 rounded">View Result</a>
                @endcan
                <a href="/" class="px-6 py-2 text-white bg-orange-700 rounded">Close</a>
            </div>
           
        </div>

@endsection