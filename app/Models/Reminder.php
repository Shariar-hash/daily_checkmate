<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'reminder_time',
        'is_snoozed',
        'snoozed_until',
        'color'
    ];

    protected $casts = [
        'reminder_time' => 'datetime',
        'snoozed_until' => 'datetime',
        'is_snoozed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

