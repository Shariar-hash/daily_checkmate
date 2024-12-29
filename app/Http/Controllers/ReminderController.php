<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Services\ReminderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_time' => 'required|date',
            'color' => 'nullable|string|max:7'
        ]);

        $this->reminderService->create($validated);
        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully');
    }

    public function update(Request $request, Reminder $reminder)
    {
        
        if (Gate::denies('update', $reminder)) {
            abort(403, 'You are not authorized to update this reminder.');
        }
    
        
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
        if (Gate::denies('update', $reminder)) {
            abort(403, 'You are not authorized to snooze this reminder.');
        }
    
        $validated = $request->validate([
            'snooze_until' => 'required|date|after:now'
        ]);
    
       
        $snoozeUntil = new \DateTime($validated['snooze_until']);
    
        
        $reminder->update([
            'is_snoozed' => true,
            'snoozed_until' => $snoozeUntil, 
        ]);
    
        return redirect()->route('reminders.index')->with('success', 'Reminder snoozed successfully');
    }
    public function destroy(Reminder $reminder)
    {
        
        if (Gate::denies('delete', $reminder)) {
            abort(403, 'You are not authorized to delete this reminder.');
        }
    
        
    
        $this->reminderService->delete($reminder);
        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully');
    }


    public function create()
{
    return view('reminders.create');
}

public function edit($id)
    {
        
        $reminder = Reminder::findOrFail($id);

        
        return view('reminders.edit', compact('reminder'));
    }


}
