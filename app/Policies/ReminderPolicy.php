<?php

namespace App\Policies;

use App\Models\Reminder;
use App\Models\User;

class ReminderPolicy
{
    public function update(User $user, Reminder $reminder)
    {
        return $user->id === $reminder->user_id;
    }

    public function delete(User $user, Reminder $reminder)
    {
        return $user->id === $reminder->user_id;
    }
}
