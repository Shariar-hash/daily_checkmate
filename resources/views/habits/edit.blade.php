@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Habit</h1>

    <form action="{{ route('habits.update', $habit) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $habit->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $habit->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="frequency">Frequency</label>
            <select name="frequency" id="frequency" class="form-control" required>
                <option value="daily" {{ old('frequency', $habit->frequency) == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('frequency', $habit->frequency) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('frequency', $habit->frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>

        <div class="form-group">
            <label for="color">Color (Optional)</label>
            <input type="color" name="color" id="color" class="form-control" value="{{ old('color', $habit->color) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Habit</button>
    </form>

</div>
@endsection
