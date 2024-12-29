@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a New Habit</h1>

    <form action="{{ route('habits.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Habit Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="frequency">Frequency</label>
            <select name="frequency" id="frequency" class="form-control" required>
                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>
        <div class="form-group">
    <label for="color">Color (Optional)</label>
    <input type="color" name="color" id="color" class="form-control" value="{{ old('color', $habit->color ?? '') }}">
</div>

        

        <button type="submit" class="btn btn-primary mt-3">Create Habit</button>
    </form>
</div>
@endsection
