<?php

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;

class HabitPolicy
{
    public function view(User $user, Habit $habit)
    {
        // Allow viewing if the habit belongs to the user
        return $habit->user_id === $user->id;
    }

    public function update(User $user, Habit $habit)
    {
        // Allow updating if the habit belongs to the user
        return $habit->user_id === $user->id;
    }

    public function delete(User $user, Habit $habit)
    {
        // Allow deleting if the habit belongs to the user
        return $habit->user_id === $user->id;
    }
}
