<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReflection extends Model
{
    protected $fillable = [
        'user_id',
        'week_start',
        'achievements',
        'challenges',
        'next_week_goals'
    ];

    protected $casts = [
        'week_start' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
