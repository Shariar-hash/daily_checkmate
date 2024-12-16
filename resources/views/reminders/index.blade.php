@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Reminders</h1>

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Reminder Button --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addReminderModal">
        Add Reminder
    </button>

    {{-- Reminder List --}}
    @if($reminders->isEmpty())
        <p>No reminders yet. Add one!</p>
    @else
        <div class="list-group">
            @foreach($reminders as $reminder)
                <div class="list-group-item d-flex justify-content-between align-items-center" 
                     style="background-color: {{ $reminder->color ?? '#f8f9fa' }}">
                    <div>
                        <h5>{{ $reminder->title }}</h5>
                        <p>{{ $reminder->description }}</p>
                        <p class="text-muted">{{ $reminder->reminder_time->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        {{-- Edit Button --}}
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                data-bs-target="#editReminderModal-{{ $reminder->id }}">
                            Edit
                        </button>

                        {{-- Delete Button --}}
                        <form action="{{ route('reminders.destroy', $reminder) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>

                        {{-- Snooze Button --}}
                        <form action="{{ route('reminders.snooze', $reminder) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="datetime-local" name="snooze_until" required>
                            <button class="btn btn-sm btn-secondary">Snooze</button>
                        </form>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editReminderModal-{{ $reminder->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('reminders.update', $reminder) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Reminder</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" 
                                               value="{{ $reminder->title }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" name="description">{{ $reminder->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reminder_time" class="form-label">Reminder Time</label>
                                        <input type="datetime-local" class="form-control" name="reminder_time" 
                                               value="{{ $reminder->reminder_time->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="color" class="form-label">Color</label>
                                        <input type="color" class="form-control form-control-color" name="color" 
                                               value="{{ $reminder->color ?? '#f8f9fa' }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('reminders.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="reminder_time" class="form-label">Reminder Time</label>
                        <input type="datetime-local" class="form-control" name="reminder_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="color" class="form-control form-control-color" name="color" value="#f8f9fa">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Reminder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
