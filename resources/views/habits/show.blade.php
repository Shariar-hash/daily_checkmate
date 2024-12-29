@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $habit->title }}</h1>
    <p><strong>Description:</strong> {{ $habit->description }}</p>
    <p><strong>Frequency:</strong> {{ ucfirst($habit->frequency) }}</p>
    <p><strong>Streak:</strong> {{ $habit->streak }}</p>
    <p><strong>Completion Rate:</strong> {{ $habit->completion_rate ?? '0%' }}</p>

    <hr>

    <!-- Form for Logging Completion -->
    <h2>Log Completion</h2>
    <form action="{{ route('habits.logCompletion', $habit->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Mark as Completed</button>
    </form>

    <hr>

    <!-- Logs Section -->
    <h2>Completion Logs</h2>
    @if ($habit->logs->isEmpty())
        <p>No logs yet! Start logging your progress above.</p>
    @else
        <ul>
            @foreach ($habit->logs as $log)
                <li>{{ $log->created_at->format('M d, Y H:i') }} - Completed</li>
            @endforeach
        </ul>
    @endif

    <hr>

    <!-- Back to Dashboard -->
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection
