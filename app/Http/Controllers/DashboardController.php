<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentTime = now();
        $user = Auth::user();
        $todoList = $user->todoLists()->first();


        $startOfWeek = now()->startOfWeek();
        
        $weeklyStats = collect(range(0, 6))->map(function ($day) use ($user, $startOfWeek) {
            $date = $startOfWeek->copy()->addDays($day);
            return [
                'date' => $date->format('D'),
                'tasks' => $user->tasks()
                    ->whereDate('tasks.created_at', $date)  
                    ->where('tasks.is_completed', true)     
                    ->count(),
                'habits' => $user->habits()
                    ->whereHas('logs', function ($query) use ($date) {
                        $query->whereDate('completed_date', $date);
                    })
                    ->count()
            ];
        });

        $exercises = [
            [
                'title' => 'Box Breathing',
                'duration' => 4,
                'description' => 'Inhale 4s, Hold 4s, Exhale 4s, Hold 4s'
            ],
            [
                'title' => '4-7-8 Breathing',
                'duration' => 5,
                'description' => 'Inhale 4s, Hold 7s, Exhale 8s'
            ],
            [
                'title' => 'Deep Breathing',
                'duration' => 3,
                'description' => 'Inhale 3s, Exhale 3s'
            ]
        ];


        $recentTasks = $user->todoLists()
        ->with(['tasks' => function($query) {
            $query->where('is_completed', false)
                  ->orderBy('due_date', 'asc');
        }])
        ->get()
        ->pluck('tasks')
        ->flatten();

    
    $todaysHabits = $user->habits()
        ->with(['habitLogs' => function($query) {
            $query->whereDate('completed_date', Carbon::today());
        }])
        ->get()
        ->map(function($habit) {
            $habit->completed_today = $habit->habitLogs->isNotEmpty();
            return $habit;
        });

    
    $upcomingReminders = $user->reminders()
        ->where('reminder_time', '>=', $currentTime)
        ->where(function($query) {
            $query->where('is_snoozed', false)
                  ->orWhere('snoozed_until', '<=', now());
        })
        ->orderBy('reminder_time', 'asc')
        ->get();


        
        $activityData = $this->getActivityData($user);

    return view('dashboard', compact(
        'recentTasks',
        'todaysHabits',
        'upcomingReminders',
        'activityData',
        'weeklyStats'
    ));

    $taskCount = $recentTasks->count();
    $reminderCount = $upcomingReminders->count();
}

    private function getActivityData($user)
    {
        $dates = collect(range(6, 0))->map(function($days) {
            return Carbon::now()->subDays($days);
        });

        return $dates->map(function($date) use ($user) {
            return [
                'date' => $date->format('D'),
                'tasks_completed' => $user->todoLists()
                    ->whereHas('tasks', function($query) use ($date) {
                        $query->whereDate('updated_at', $date)
                            ->where('is_completed', true);
                    })
                    ->count(),
                'habits_maintained' => $user->habits()
                    ->whereHas('habitLogs', function($query) use ($date) {
                        $query->whereDate('completed_date', $date);
                    })
                    ->count(),
                'reminders_set' => $user->reminders()
                    ->whereDate('reminder_time', $date)
                    ->count(),
            ];
        });
    }
}