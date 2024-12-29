<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Services\HabitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Include this

class HabitController extends Controller
{
    use AuthorizesRequests; // Use this trait

    protected $habitService;

    public function __construct(HabitService $habitService)
    {
        $this->habitService = $habitService;
    }

    public function index()
    {
        $habits = Auth::user()->habits()->withCount('logs')->get();
        return view('habits.index', compact('habits'));
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:daily,weekly,monthly',
            'color' => 'nullable|string|max:7'
        ]);

        $habit = $this->habitService->create($validated);
        return redirect()->route('habits.show', $habit)->with('success', 'Habit created successfully');
    }

    public function show(Habit $habit)
    {
        $this->authorize('view', $habit); // Authorizes if the user can view the habit
        $habit->load('logs');
        return view('habits.show', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        $this->authorize('update', $habit); // Authorizes if the user can update the habit
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:daily,weekly,monthly',
            'color' => 'nullable|string|max:7'
        ]);

        $this->habitService->update($habit, $validated);
        return redirect()->route('habits.index')->with('success', 'Habit updated successfully');
    }

    public function logCompletion(Habit $habit)
    {
        $this->authorize('update', $habit); // Authorizes if the user can update the habit
        $this->habitService->logCompletion($habit);
        return redirect()->back()->with('success', 'Habit completion logged');
    }

    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit); // Authorizes if the user can delete the habit
        $habit->delete();
        return redirect()->route('habits.index')->with('success', 'Habit deleted successfully');
    }
}
