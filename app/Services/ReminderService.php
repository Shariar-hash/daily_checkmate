<?php

namespace App\Services;

use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;

class ReminderService
{
    public function create(array $data)
    {
        return Auth::user()->reminders()->create($data);
    }

    public function update(Reminder $reminder, array $data)
    {
        $reminder->update($data);
        return $reminder;
    }

    public function snooze(Reminder $reminder, \DateTime $snoozedUntil)
    {
        $reminder->update([
            'is_snoozed' => true,
            'snoozed_until' => $snoozedUntil
        ]);
        return $reminder;
    }

    public function delete(Reminder $reminder)
    {
        return $reminder->delete();
    }
}
