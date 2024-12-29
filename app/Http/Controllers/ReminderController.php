<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    protected $reminderService;

    public function __construct(ReminderService $reminderService)
    {
        $this->reminderService = $reminderService;
    }

    public function index()
    {
        $reminders = Auth::user()->reminders()->orderBy('reminder_time')->get();
        return view('reminders.index', compact('reminders'));
    }

    public function create()
    {
        return view('reminders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_time' => 'required|date',
            'color' => 'nullable|string|max:7'
        ]);

        $reminder = $this->reminderService->create($validated);
        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully');
    }

    public function show(Reminder $reminder)
    {
        $this->authorize('view', $reminder);
        return view('reminders.show', compact('reminder'));
    }

    public function edit(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        return view('reminders.edit', compact('reminder'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_time' => 'required|date',
            'color' => 'nullable|string|max:7'
        ]);

        $this->reminderService->update($reminder, $validated);
        return redirect()->route('reminders.index')->with('success', 'Reminder updated successfully');
    }

    public function snooze(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $validated = $request->validate([
            'snooze_until' => 'required|date|after:now'
        ]);

        $this->reminderService->snooze($reminder, $validated['snooze_until']);
        return redirect()->route('reminders.index')->with('success', 'Reminder snoozed');
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        $this->reminderService->delete($reminder);
        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully');
    }
}