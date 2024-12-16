<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Services\HabitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency' => 'required|in:daily,weekly,monthly',
            'color' => 'nullable|string|max:7'
        ]);

        $this->habitService->create($validated);
        return redirect()->route('habits.index')->with('success', 'Habit created successfully');
    }

    public function show(Habit $habit)
    {
        $this->authorize('view', $habit);
        $habit->load('logs');
        return view('habits.show', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        $this->authorize('update', $habit);
        
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
        $this->authorize('update', $habit);
        $this->habitService->logCompletion($habit);
        return redirect()->back()->with('success', 'Habit completion logged');
    }

    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit);
        $habit->delete();
        return redirect()->route('habits.index')->with('success', 'Habit deleted successfully');
    }
}
