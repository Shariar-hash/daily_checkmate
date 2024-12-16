<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Services\TodoListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{
    protected $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    public function index()
    {
        $lists = Auth::user()->todoLists()
            ->with('tasks')
            ->where('is_archived', false)
            ->get();
        
        return view('todo-lists.index', compact('lists'));
    }

    public function archived()
    {
        $lists = Auth::user()->todoLists()
            ->with('tasks')
            ->where('is_archived', true)
            ->get();
        
        return view('todo-lists.archived', compact('lists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7'
        ]);

        $list = $this->todoListService->create($validated);
        return redirect()->route('todo-lists.show', $list)->with('success', 'List created successfully');
    }

    public function show(TodoList $todoList)
    {
        $this->authorize('view', $todoList);
        $todoList->load('tasks');
        return view('todo-lists.show', compact('todoList'));
    }

    public function update(Request $request, TodoList $todoList)
    {
        $this->authorize('update', $todoList);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7'
        ]);

        $this->todoListService->update($todoList, $validated);
        return redirect()->back()->with('success', 'List updated successfully');
    }

    public function archive(TodoList $todoList)
    {
        $this->authorize('update', $todoList);
        $this->todoListService->archive($todoList);
        return redirect()->route('todo-lists.index')->with('success', 'List archived successfully');
    }

    public function restore(TodoList $todoList)
    {
        $this->authorize('update', $todoList);
        $this->todoListService->restore($todoList);
        return redirect()->route('todo-lists.archived')->with('success', 'List restored successfully');
    }

    public function destroy(TodoList $todoList)
    {
        $this->authorize('delete', $todoList);
        $this->todoListService->delete($todoList);
        return redirect()->route('todo-lists.index')->with('success', 'List deleted successfully');
    }
}
