@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $habit->title }}</h1>
    <p><strong>Description:</strong> {{ $habit->description }}</p>
    <p><strong>Frequency:</strong> {{ ucfirst($habit->frequency) }}</p>
    <p><strong>Streak:</strong> {{ $habit->streak }}</p>
    <p><strong>Completion Rate:</strong> {{ $habit->completion_rate }}%</p>

    <h3>Completion Logs</h3>
    @if($habit->logs->isEmpty())
        <p>No logs yet. Start logging completions!</p>
    @else
        <ul class="list-group">
            @foreach($habit->logs as $log)
                <li class="list-group-item">
                    <p>{{ $log->completed_date->format('Y-m-d') }}</p>
                </li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('habits.log', $habit) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-success">Log Completion</button>
    </form>

    <form action="{{ route('habits.destroy', $habit) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Habit</button>
    </form>
</div>
@endsection
