<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'theme',
        'break_reminders',
        'break_interval'
    ];

    protected $casts = [
        'break_reminders' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
