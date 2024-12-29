<?php

namespace App\Services;

use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HabitService
{
    public function create(array $data)
    {
        return Auth::user()->habits()->create($data);
    }

    public function update(Habit $habit, array $data)
    {
        $habit->update($data);
        return $habit;
    }

    public function logCompletion(Habit $habit)
    {
        $today = Carbon::today();
        
        if (!$habit->logs()->whereDate('completed_date', $today)->exists()) {
            $habit->logs()->create(['completed_date' => $today]);
            $this->updateStreak($habit);
            $this->updateCompletionRate($habit);
        }
        
        return $habit;
    }

    private function updateStreak(Habit $habit)
    {
        $lastLog = $habit->logs()
            ->where('completed_date', '<', Carbon::today())
            ->latest('completed_date')
            ->first();

        if ($lastLog && $lastLog->completed_date->isYesterday()) {
            $habit->increment('streak');
        } else {
            $habit->update(['streak' => 1]);
        }
    }

    private function updateCompletionRate(Habit $habit)
    {
        $totalDays = Carbon::parse($habit->created_at)->diffInDays(Carbon::now()) + 1;
        $completedDays = $habit->logs()->count();
        
        $completionRate = ($completedDays / $totalDays) * 100;
        $habit->update(['completion_rate' => $completionRate]);
    }
}
