<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'color'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
