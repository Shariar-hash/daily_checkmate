@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Form to add a new To-Do -->
        <form action="{{ route('todos.store') }}" method="POST">
            @csrf
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div>
                <button type="submit">Add To-Do</button>
            </div>
        </form>

        <hr>

        <!-- Display existing To-Dos -->
        <h3>Your To-Dos</h3>
        @foreach($todos as $todo)
            <div class="todo-item">
                <h4>{{ $todo->title }}</h4>
                <p><strong>Description:</strong> {{ $todo->description ?? 'No description provided.' }}</p>

                <!-- Mark Done Button (or Unmark) -->
                <form action="{{ route('todos.markDone', $todo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="mark-done-btn">
                        @if ($todo->is_done)
                            Unmark as Done
                        @else
                            Mark as Done
                        @endif
                    </button>
                </form>

                <!-- Delete Todo -->
                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection

