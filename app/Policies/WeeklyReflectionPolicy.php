<?php

namespace App\Policies;

use App\Models\WeeklyReflection;
use App\Models\User;

class WeeklyReflectionPolicy
{
    public function view(User $user, WeeklyReflection $reflection)
    {
        return $user->id === $reflection->user_id;
    }

    public function update(User $user, WeeklyReflection $reflection)
    {
        return $user->id === $reflection->user_id;
    }

    public function delete(User $user, WeeklyReflection $reflection)
    {
        return $user->id === $reflection->user_id;
    }
}