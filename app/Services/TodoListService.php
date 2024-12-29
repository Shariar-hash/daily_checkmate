<?php

namespace App\Services;

use App\Models\TodoList;
use Illuminate\Support\Facades\Auth;

class TodoListService
{
    public function create(array $data)
    {
        return Auth::user()->todoLists()->create($data);
    }

    public function update(TodoList $todoList, array $data)
    {
        $todoList->update($data);
        return $todoList;
    }

    public function archive(TodoList $todoList)
    {
        $todoList->update(['is_archived' => true]);
        return $todoList;
    }

    public function restore(TodoList $todoList)
    {
        $todoList->update(['is_archived' => false]);
        return $todoList;
    }

    public function delete(TodoList $todoList)
    {
        return $todoList->delete();
    }
}
