<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function toggleComplete(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);
        return $task;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}
