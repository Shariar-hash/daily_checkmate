{{-- resources/views/tasks/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="mb-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    Add New Task
                </button>
            </div>

            
            <div class="card">
                <div class="card-header">Tasks</div>
                <div class="card-body">
                    @if($tasks->isEmpty())
                        <p>No tasks available.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Due Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'info') }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $task->is_completed ? 'success' : 'secondary' }}">
                                                {{ $task->is_completed ? 'Completed' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('tasks.toggle', $task->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $task->is_completed ? 'btn-secondary' : 'btn-success' }}">
                                                    {{ $task->is_completed ? 'Mark Pending' : 'Mark Complete' }}
                                                </button>
                                            </form>
                                            
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editTaskModal{{ $task->id }}">
                                                Edit
                                            </button>

                                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('tasks.store', ['todoList' => $todoList ?? null]) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>


@foreach($tasks as $task)
<div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title{{ $task->id }}" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title{{ $task->id }}" name="title" value="{{ $task->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $task->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description{{ $task->id }}" name="description" rows="3">{{ $task->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="due_date{{ $task->id }}" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date{{ $task->id }}" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="priority{{ $task->id }}" class="form-label">Priority</label>
                        <select class="form-select" id="priority{{ $task->id }}" name="priority" required>
                            <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@endsection