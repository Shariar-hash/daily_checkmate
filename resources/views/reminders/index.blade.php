<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reminders</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .reminder-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 12px;
            border: none;
        }
        
        .reminder-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            background: linear-gradient(45deg, #4a6bff, #45caff);
            color: white;
            border-radius: 0 0 25px 25px;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
        }

        .btn-floating {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
        }

        .reminder-time {
            background-color: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }

        .snooze-badge {
            background: linear-gradient(45deg, #ff4a4a, #ff45b5);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        input[type="color"] {
            height: 40px;
            padding: 0;
            border: none;
            border-radius: 8px;
            overflow: hidden;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .success-alert {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border: none;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    
    @include('layouts.navigation')

    
    <div class="page-header mb-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Your Reminders</h1>
            <p class="lead mb-0">Stay organized and never miss an important task</p>
        </div>
    </div>

    <div class="container pb-5">
        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert success-alert alert-dismissible fade show mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        
        @if($reminders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-check display-1 text-muted mb-3"></i>
                <h3 class="text-muted">No reminders yet</h3>
                <p class="text-muted mb-4">Create your first reminder to get started</p>
                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addReminderModal">
                    <i class="bi bi-plus-lg me-2"></i>Add Reminder
                </button>
            </div>
        @else
            <div class="row g-4">
                @foreach($reminders as $reminder)
                    <div class="col-md-6 col-lg-4">
                        <div class="card reminder-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h3 class="card-title h5 mb-0">{{ $reminder->title }}</h3>
                                    <span class="reminder-time">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $reminder->reminder_time->format('M d, Y H:i') }}
                                    </span>
                                </div>
                                <p class="card-text text-muted">{{ $reminder->description }}</p>
                                
                                {{-- Snooze Section --}}
                                <div class="mb-3">
                                    @if(!$reminder->is_snoozed)
                                        <form action="{{ route('reminders.snooze', $reminder) }}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input type="datetime-local" name="snooze_until" class="form-control" required>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="bi bi-alarm me-1"></i>Snooze
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="snooze-badge">
                                            <i class="bi bi-alarm-fill me-2"></i>
                                            Snoozed Until: {{ $reminder->snoozed_until->format('Y-m-d H:i') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('reminders.edit', $reminder) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('reminders.destroy', $reminder) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        
        <button class="btn btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#addReminderModal">
            <i class="bi bi-plus-lg fs-4"></i>
        </button>
    </div>

    
    <div class="modal fade" id="addReminderModal" tabindex="-1" aria-labelledby="addReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addReminderModalLabel">Create New Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reminders.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="form-label fw-medium">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                placeholder="Enter reminder title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-medium">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                class="form-control @error('description') is-invalid @enderror" 
                                placeholder="Enter reminder details">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reminder_time" class="form-label fw-medium">Reminder Time</label>
                            <input type="datetime-local" name="reminder_time" id="reminder_time" 
                                value="{{ old('reminder_time') }}" 
                                class="form-control @error('reminder_time') is-invalid @enderror" required>
                            @error('reminder_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="color" class="form-label fw-medium">Color</label>
                            <input type="color" name="color" id="color" 
                                value="{{ old('color', '#4F46E5') }}" 
                                class="form-control form-control-color w-100">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>Create Reminder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>