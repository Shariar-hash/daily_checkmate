<?php

namespace App\Http\Controllers;
use App\Models\Habit;

use Illuminate\Http\Request;



class HabitController extends Controller
{
    public function index()
    {
        // Fetch all habits from the database
        $habits = Habit::all();

        // Return the habits view with the habits data
        return view('habits.index', compact('habits'));
    }

    // Other methods like store, update, destroy, etc.





    // Define the store method to handle POST requests for creating a habit
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255', // Ensure a valid title is provided
        
            'frequency' => 'required|string|max:100', // Frequency of the habit
            'description' => 'nullable|string',
        ]);
         // Check the values being validated

    // Create the habit in the database
    

        // Create a new habit record in the database
        $habit = Habit::create($validated);
         

        // Redirect to the index page (or wherever you want)
        return redirect()->route('habits.index')->with('habit', $habit);
              
    }

    // Other methods like show, edit, update, destroy, etc.
}
