<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function store(Request $request, TodoList $todoList)
    {
        $this->authorize('update', $todoList);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
        ]);

        $validated['todo_list_id'] = $todoList->id;
        $this->taskService->create($validated);
        
        return redirect()->back()->with('success', 'Task created successfully');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->todoList);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
        ]);

        $this->taskService->update($task, $validated);
        return redirect()->back()->with('success', 'Task updated successfully');
    }

    public function toggleComplete(Task $task)
    {
        $this->authorize('update', $task->todoList);
        $this->taskService->toggleComplete($task);
        return redirect()->back()->with('success', 'Task status updated');
    }

    public function destroy(Task $task)
    {
        $this->authorize('update', $task->todoList);
        $this->taskService->delete($task);
        return redirect()->back()->with('success', 'Task deleted successfully');
    }
}

