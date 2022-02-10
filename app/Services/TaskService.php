<?php

namespace App\Services;

use App\Task;
use Illuminate\Database\Eloquent\Model;

class TaskService
{
    public function addTask(array $data): Model
    {
        $task = new Task;
        $task->label = $data['label'];
        $task->sort_order = Task::first() ? Task::orderBy('id', 'desc')->first()->id + 1 : 1;
        $task->completed_at = now();

        $task->save();
        return $task;
    }
}
