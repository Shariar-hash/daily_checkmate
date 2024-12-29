@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Reminder</div>
                <div class="card-body">
                    <form action="{{ route('reminders.update', $reminder) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $reminder->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $reminder->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="reminder_time" class="form-label">Reminder Time</label>
                            <input type="datetime-local" class="form-control" id="reminder_time" name="reminder_time" 
                                   value="{{ $reminder->reminder_time ? $reminder->reminder_time->format('Y-m-d\TH:i') : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color (optional)</label>
                            <input type="color" class="form-control form-control-color" id="color" name="color" 
                                   value="{{ $reminder->color ?? '#000000' }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Reminder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection