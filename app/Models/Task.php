<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'todo_list_id',
        'title',
        'description',
        'due_date',
        'priority',
        'is_completed'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_completed' => 'boolean'
    ];

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
