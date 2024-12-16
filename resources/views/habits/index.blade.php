@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Habit Tracker</h1>

    <!-- Add Habit Button -->
    <div class="text-end mb-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHabitModal">
            Add New Habit
        </button>
    </div>

    <!-- Habits List -->
    <div class="row">
        @forelse($habits as $habit)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color: {{ $habit->color ?? '#000' }}">{{ $habit->title }}</h5>
                        <p class="card-text">{{ $habit->description }}</p>
                        <p><strong>Frequency:</strong> {{ ucfirst($habit->frequency) }}</p>
                        <p><strong>Streak:</strong> {{ $habit->streak }} days</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('habits.show', $habit) }}" class="btn btn-info btn-sm">View</a>
                            <form method="POST" action="{{ route('habits.destroy', $habit) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No habits added yet!</p>
        @endforelse
    </div>
</div>

<!-- Add Habit Modal -->
<div class="modal fade" id="addHabitModal" tabindex="-1" aria-labelledby="addHabitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('habits.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addHabitModalLabel">Add New Habit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Habit Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="frequency" class="form-label">Frequency</label>
                        <select name="frequency" id="frequency" class="form-select" required>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" name="color" id="color" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Habit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
