<!-- resources/views/reminders/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Reminder List</h1>

    <form action="{{ route('reminders.store') }}" method="POST">
        @csrf
        <label for="title">Reminder Title</label>
        <input type="text" name="title" id="title" required>

        <label for="reminder_at">Reminder Date & Time</label>
        <input type="datetime-local" name="reminder_at" id="reminder_at" required>

        <button type="submit" class="btn btn-primary">Add Reminder</button>
    </form>

    <ul>
        @foreach($reminders as $reminder)
            <li>
                {{ $reminder->title }} - {{ $reminder->reminder_at }}
                <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

