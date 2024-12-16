@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Archived To-Do Lists</h1>

    <!-- Display Archived To-Do Lists -->
    <div class="row">
        @forelse($lists as $list)
            <div class="col-md-4">
                <div class="card mb-4" style="border-left: 5px solid {{ $list->color ?? '#000' }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $list->title }}</h5>
                        <p class="card-text">{{ $list->tasks->count() }} tasks</p>
                        <form action="{{ route('todo-lists.restore', $list) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                        </form>
                        <form action="{{ route('todo-lists.destroy', $list) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No archived to-do lists found.</p>
        @endforelse
    </div>

    <!-- Link Back to Active Lists -->
    <a href="{{ route('todo-lists.index') }}" class="btn btn-primary">Back to Active Lists</a>
</div>
@endsection
