<?php
namespace App\Http\Controllers;

use App\Models\Habit;
use App\Services\HabitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        
        if (Gate::denies('view', $habit)) {
            abort(403, 'You are not authorized to view this habit.');
        }

        $habit->load('logs');
        return view('habits.show', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        
        if (Gate::denies('update', $habit)) {
            abort(403, 'You are not authorized to update this habit.');
        }

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
        
        if (Gate::denies('update', $habit)) {
            abort(403, 'You are not authorized to log completion for this habit.');
        }

        $this->habitService->logCompletion($habit);
        return redirect()->back()->with('success', 'Habit completion logged');
    }

    public function destroy(Habit $habit)
    {
        
        if (Gate::denies('delete', $habit)) {
            abort(403, 'You are not authorized to delete this habit.');
        }

        $habit->delete();
        return redirect()->route('habits.index')->with('success', 'Habit deleted successfully');
    }
}