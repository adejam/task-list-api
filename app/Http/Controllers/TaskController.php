<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Services\TaskService;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private $_taskService;

    public function __construct(TaskService $taskService)
    {
        $this->_taskService = $taskService;
    }

    public function addTask(Request $request): Response
    {
        $rules = array(
            'label' => ['required', 'string', 'max:191'],
        );

        $data = request()->validate($rules);
        $task = $this->_taskService->addTask($data);
        return response(
            [
            'message' => "Task Added Successfully",
            'task' => $task,
            ],
            201
        );
    }

    public function updateTask(Request $request, int $id): Response
    {
        $rules = array(
            'label' => ['nullable', 'string', 'max:191'],
            'sort_order' => ['nullable', 'integer'],
            'task_completed_status' => ['nullable', 'boolean'],
        );

        $data = request()->validate($rules);
        
        $task = Task::find($id);
        if (!$task) {
            abort(404, "The page does not exist.");
        }

        $task = $this->_taskService->updateTask($data, $task);
        return response(
            [
            'message' => "Task Updated Successfully",
            'task' => $task,
            ],
            200
        );
    }
}
