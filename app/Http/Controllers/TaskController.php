<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    private $_taskService;

    public function __construct(TaskService $taskService)
    {
        $this->_taskService = $taskService;
    }

    public function addTask(Request $request)
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
}
