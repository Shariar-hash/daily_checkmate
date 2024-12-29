@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Reminder</div>
                <div class="card-body">
                    <form action="{{ route('reminders.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="reminder_time" class="form-label">Reminder Time</label>
                            <input type="datetime-local" class="form-control" id="reminder_time" name="reminder_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color (optional)</label>
                            <input type="color" class="form-control form-control-color" id="color" name="color">
                        </div>
                        <button type="submit" class="btn btn-primary">Create Reminder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection