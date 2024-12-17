

@extends('layouts.app')

@section('content')
    <h2>Add a New Habit</h2>

    <!-- Form for creating a habit -->
    <form action="{{ route('habits.store') }}" method="POST">
        @csrf

        <label for="title">Habit Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
       
        <label for="frequency">Frequency</label>
        <input type="text" name="frequency" id="frequency" required>

        <button type="submit">Add Habit</button>
    </form>

    <!-- If a habit was just created, display the habit details -->
    @if(session('habit'))
        <div class="habit-details">
            <h3>Habit Added Successfully!</h3>
            <p><strong>Title:</strong> {{ session('habit')->title }}</p>
            <p><strong>Frequency:</strong> {{ session('habit')->frequency }}</p>
            <p><strong>Description:</strong> {{ session('habit')->description ?? 'No description provided.' }}</p>
        </div>
    @endif

    <h2>Your Habits</h2>
    <!-- List all habits stored in the database -->
    @foreach($habits as $habit)
        <div class="habit-item">
            <h3>{{ $habit->title }}</h3>
            <p><strong>Frequency:</strong> {{ $habit->frequency }}</p>
            <p><strong>Description:</strong> {{ $habit->description ?? 'No description provided.' }}</p>
        </div>
    @endforeach

@endsection

