<?php

namespace App\Services;

use App\Task;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ArrayHelper;

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

    public function updateTask(array $data, Task $task): Model
    {
        if (ArrayHelper::keyExistAndNotFalse('label', $data)) {
            $task->label = $data['label'];
        }

        if (ArrayHelper::keyExistAndNotFalse('sort_order', $data)) {
            $taskWithTheSortOrder = Task::where('sort_order', $data['sort_order'])->first();
            $newOrderForTheTaskWithTheSortOrder = $task->sort_order;

            if ($taskWithTheSortOrder) {
                $task->sort_order = $taskWithTheSortOrder->sort_order;
                $updatetaskWithSortOrder = Task::find($taskWithTheSortOrder->sort_order);
                $updatetaskWithSortOrder->sort_order = $newOrderForTheTaskWithTheSortOrder;
                $updatetaskWithSortOrder->updated_at = now();
                $updatetaskWithSortOrder->save();
            } else {
                $task->sort_order = $data['sort_order'];
            }
        }

        if (array_key_exists('task_completed_status', $data)) {
            if ($data['task_completed_status']) {
                $task->completed_at = now();
            } else {
                $task->completed_at = $task->created_at;
            }
        }

        if (ArrayHelper::keyExistAndNotFalse('label', $data)
            || ArrayHelper::keyExistAndNotFalse('sort_order', $data)
            || array_key_exists('task_completed_status', $data)
        ) {
            $task->updated_at = now();
            $task->save();
        }
        
        return $task;
    }
}
