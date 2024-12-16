@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your To-Do Lists</h1>

        <!-- Form to Create New Todo List -->
        <form action="{{ route('todo-lists.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color (optional)</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>

            <button type="submit" class="btn btn-primary">Create List</button>
        </form>

        <!-- Existing To-Do Lists Display -->
        <div class="todo-lists mt-4">
            @foreach ($lists as $list)
                <div class="list-item">
                    <h4>{{ $list->title }}</h4>
                    <!-- Display tasks, etc. -->
                </div>
            @endforeach
        </div>
    </div>
@endsection
