@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $todoList->title }}</h1>

    <!-- Add Task Form -->
    <form action="{{ route('tasks.store', $todoList) }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="task" class="form-control" placeholder="New Task" required>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </div>
        @error('task')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </form>

    <!-- Display Tasks -->
    <ul class="list-group">
        @forelse($todoList->tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $task->description }}</span>
                <div>
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $task->is_complete ? 'btn-success' : 'btn-secondary' }}">
                            {{ $task->is_complete ? 'Completed' : 'Mark Complete' }}
                        </button>
                    </form>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </li>
        @empty
            <p>No tasks found for this list. Add one above!</p>
        @endforelse
    </ul>

    <!-- Back to Lists -->
    <a href="{{ route('todo-lists.index') }}" class="btn btn-secondary mt-3">Back to Lists</a>
</div>
@endsection
