<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReflection;
use App\Services\WeeklyReflectionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeeklyReflectionController extends Controller
{
    protected $weeklyReflectionService;

    public function __construct(WeeklyReflectionService $weeklyReflectionService)
    {
        $this->weeklyReflectionService = $weeklyReflectionService;
    }

    public function index()
    {
        $reflections = Auth::user()->weeklyReflections()->latest('week_start')->get();
        return view('reflections.index', compact('reflections'));
    }

    public function create()
    {
        $weekStart = Carbon::now()->startOfWeek();
        return view('reflections.create', compact('weekStart'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'week_start' => 'required|date',
            'achievements' => 'required|string',
            'challenges' => 'required|string',
            'lessons_learned' => 'required|string',
            'next_week_goals' => 'required|string'
        ]);

        $this->weeklyReflectionService->create($validated);
        return redirect()->route('reflections.index')->with('success', 'Weekly reflection saved successfully');
    }

    public function show(WeeklyReflection $reflection)
    {
        $this->authorize('view', $reflection);
        return view('reflections.show', compact('reflection'));
    }

    public function update(Request $request, WeeklyReflection $reflection)
    {
        $this->authorize('update', $reflection);
        
        $validated = $request->validate([
            'week_start' => 'required|date',
            'achievements' => 'required|string',
            'challenges' => 'required|string',
            'lessons_learned' => 'required|string',
            'next_week_goals' => 'required|string'
        ]);

        $this->weeklyReflectionService->update($reflection, $validated);
        return redirect()->route('reflections.index')->with('success', 'Weekly reflection updated successfully');
    }

    public function destroy(WeeklyReflection $reflection)
    {
        $this->authorize('delete', $reflection);
        $this->weeklyReflectionService->delete($reflection);
        return redirect()->route('reflections.index')->with('success', 'Weekly reflection deleted successfully');
    }
}
