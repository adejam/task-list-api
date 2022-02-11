<?php

namespace App\Services;

use App\Task;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ArrayHelper;
use DB;

class TaskService
{
    /**
     * This method checks for the allow_duplicates settings based on if the current settings allows creating more
     * than one task with the same label
     *
     * @return bool // returns true or false depending on the value of allow_duplicates
     */
    public static function canDuplicateTaskCanBeAdded(): bool
    {
        $allow_duplicates = DB::table('settings')->where('param', 'allow_duplicates')->first();
        $allow_duplicates_value = intval($allow_duplicates->value, $base = 10);
        if ($allow_duplicates_value) {
            return true;
        }
        return false;
    }
    
    /**
     * This method adds a task to the database. It takes is the validated data from controller and returns the model instance
     * of the task created
     *
     * @param array $data // array of validated data to be added
     *
     * @return Illuminate\Database\Eloquent\Model // model instance of the task added.
     */
    public function addTask(array $data): Model
    {
        $task = new Task;
        $labelValue = strtolower($data['label']);
        $existingTask = Task::where('label', $labelValue)->first();
        if ($existingTask) {
            if (!$this->canDuplicateTaskCanBeAdded()) {
                abort(400, 'duplicate task cannot be added due to allow_duplicates settings');
            } else {
                $task->label = $labelValue;
            }
        } else {
            $task->label = $labelValue;
        }
        
        
        $task->sort_order = Task::first() ? Task::orderBy('id', 'desc')->first()->id + 1 : 1;
        $task->completed_at = now();

        $task->save();
        return $task;
    }
    
    /**
     * This method updates an existing task to the database. It takes is the validated data and task to be updated as params
     *  from controller and returns  the model instance of the task updated
     *
     * @param array $data // array of validated data to be added
     * @param Task  $task // task model to be updated
     *
     * @return Illuminate\Database\Eloquent\Model // model instance of the task updated.
     */
    public function updateTask(array $data, Task $task): Model
    {
        if (ArrayHelper::keyExistAndNotFalse('label', $data)) {
            $labelValue = strtolower($data['label']);
            $existingTask = Task::where('label', $labelValue)->first();
            if ($existingTask && $existingTask->id !== $task->id) {
                if (!$this->canDuplicateTaskCanBeAdded()) {
                    abort(400, 'duplicate task cannot be added due to allow_duplicates settings');
                } else {
                    $task->label = $labelValue;
                }
            } else {
                $task->label = $labelValue;
            }
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
