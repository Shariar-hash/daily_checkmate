<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function store(Request $request, TodoList $todoList)
    {
        if (Gate::denies('update', $todoList)) {
            abort(403, 'You are not authorized to add tasks to this list.');
        }

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
        if (Gate::denies('update', $task->todoList)) {
            abort(403, 'You are not authorized to update tasks in this list.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high'
        ]);

        $this->taskService->update($task, $validated);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function toggleComplete(Task $task)
    {
        if (Gate::denies('update', $task->todoList)) {
            abort(403, 'You are not authorized to modify tasks in this list.');
        }

        $this->taskService->toggleComplete($task);
        return redirect()->back()->with('success', 'Task status updated');
    }

    public function destroy(Task $task)
    {
        if (Gate::denies('update', $task->todoList)) {
            abort(403, 'You are not authorized to delete tasks from this list.');
        }

        $this->taskService->delete($task);
        return redirect()->back()->with('success', 'Task deleted successfully');
    }

    public function index()
    {
        $tasks = auth()->user()->tasks;
        $todoList = auth()->user()->todoLists()->first(); 
        return view('tasks.index', compact('tasks', 'todoList'));
    }

    public function create(TodoList $todoList)
    {
        if (Gate::denies('update', $todoList)) {
            abort(403, 'You are not authorized to add tasks to this list.');
        }
        return view('tasks.create', compact('todoList'));
    }

    
    public function edit(Task $task)
    {
        
        if (Gate::denies('update', $task->todoList)) {
            abort(403, 'You are not authorized to edit tasks in this list.');
        }

        return view('tasks.edit', compact('task'));
    }
}
