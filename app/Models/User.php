<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function todoLists()
    {
        return $this->hasMany(TodoList::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function weeklyReflections()
    {
        return $this->hasMany(WeeklyReflection::class);
    }
}
