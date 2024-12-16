<?php

namespace App\Services;

use App\Models\WeeklyReflection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WeeklyReflectionService
{
    public function create(array $data)
    {
        $data['week_start'] = Carbon::parse($data['week_start'])->startOfWeek();
        return Auth::user()->weeklyReflections()->create($data);
    }

    public function update(WeeklyReflection $reflection, array $data)
    {
        if (isset($data['week_start'])) {
            $data['week_start'] = Carbon::parse($data['week_start'])->startOfWeek();
        }
        
        $reflection->update($data);
        return $reflection;
    }

    public function delete(WeeklyReflection $reflection)
    {
        return $reflection->delete();
    }
}
