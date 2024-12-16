<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Services\IdeaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    protected $ideaService;

    public function __construct(IdeaService $ideaService)
    {
        $this->ideaService = $ideaService;
    }

    public function index()
    {
        $ideas = Auth::user()->ideas()->latest()->get();
        return view('ideas.index', compact('ideas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:50'
        ]);

        $this->ideaService->create($validated);
        return redirect()->route('ideas.index')->with('success', 'Idea captured successfully');
    }

    public function update(Request $request, Idea $idea)
    {
        $this->authorize('update', $idea);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:50'
        ]);

        $this->ideaService->update($idea, $validated);
        return redirect()->route('ideas.index')->with('success', 'Idea updated successfully');
    }

    public function destroy(Idea $idea)
    {
        $this->authorize('delete', $idea);
        $this->ideaService->delete($idea);
        return redirect()->route('ideas.index')->with('success', 'Idea deleted successfully');
    }
}
