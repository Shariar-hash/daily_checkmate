@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">{{ $habit->title }}</h1>
    <p class="text-muted text-center">{{ $habit->description }}</p>

    <div class="text-end mb-3">
        <form method="POST" action="{{ route('habits.logCompletion', $habit) }}">
            @csrf
            <button type="submit" class="btn btn-success">Log Completion</button>
        </form>
    </div>

    <h3>Logs</h3>
    <ul class="list-group">
        @forelse($habit->logs as $log)
            <li class="list-group-item">Completed on {{ $log->completed_at->format('M d, Y') }}</li>
        @empty
            <li class="list-group-item">No logs yet!</li>
        @endforelse
    </ul>

    <a href="{{ route('habits.index') }}" class="btn btn-secondary mt-4">Back to Habits</a>
</div>
@endsection
