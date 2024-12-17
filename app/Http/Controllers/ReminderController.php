<?php

namespace App\Http\Controllers;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller

{
    public function index()
    {
        $reminders = Reminder::all();
        return view('reminders.index', compact('reminders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'reminder_at' => 'required|date',
        ]);

        Reminder::create($validated); // Use the Reminder model to create the reminder

        return redirect()->route('reminders.index');
    }

    public function destroy(Reminder $reminder)
    {
        $reminder->delete();
        return redirect()->route('reminders.index');
    }
}


