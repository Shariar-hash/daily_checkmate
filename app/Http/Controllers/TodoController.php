<?php

namespace App\Http\Controllers;
use App\Models\Todo;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Todo::create($validated);

        return redirect()->route('todos.index');
    }

    // public function update(Request $request, Todo $todo)
    // {
    //     $todo->update(['is_done' => $request->is_done]);

    //     return redirect()->route('todos.index');
    // }

    public function destroy($id)
    {
        // Find the Todo by ID and delete it
        $todo = Todo::findOrFail($id);
        $todo->delete();

        // Redirect back to the To-Do list page
        return redirect()->route('todos.index');
    }

    public function markDone($id)
    {
        // Find the Todo by ID
        $todo = Todo::findOrFail($id);

        // Toggle the is_done status
        $todo->is_done = !$todo->is_done;
        $todo->save();

        // Return a JSON response with the updated is_done status
        // return response()->json([
        //     'status' => 'success',
        //     'is_done' => $todo->is_done,
        // ]);
    }
}