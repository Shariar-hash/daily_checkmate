<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $startOfWeek = now()->startOfWeek();
        
        $weeklyStats = collect(range(0, 6))->map(function ($day) use ($user, $startOfWeek) {
            $date = $startOfWeek->copy()->addDays($day);
            return [
                'date' => $date->format('D'),
                'tasks' => $user->tasks()
                    ->whereDate('tasks.created_at', $date)  // Specified tasks table
                    ->where('tasks.is_completed', true)     // Specified tasks table
                    ->count(),
                'habits' => $user->habits()
                    ->whereHas('logs', function ($query) use ($date) {
                        $query->whereDate('completed_date', $date);
                    })
                    ->count()
            ];
        });

        return view('dashboard', [
            'recentTasks' => $user->tasks()->latest()->take(3)->get(),
            'todaysHabits' => $user->habits()->get(),
            'upcomingReminders' => $user->reminders()->latest()->take(3)->get(),
            'weeklyStats' => $weeklyStats
        ]);
    }
}