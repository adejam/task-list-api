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

    /**
     * This controller method fetches all tasks in the database.
     *
     * @return Illuminate\Http\Response // response returned which include the status code,
     * message and the Model object created
     */
    public function index(): Response
    {
        $tasks = Task::orderBy('sort_order')->get();
        return response(
            [
            'tasks' => $tasks,
            ],
            200
        );
    }
    
    /**
     * This controller method adds a new task. It takes in the http request as param and returns a HTTP response with status code,
     * message and the Model object created
     *
     * @param \Illuminate\Http\Request $request // Request coming from endpoint
     *
     * @return Illuminate\Http\Response // response returned which include the status code,
     * message and the Model object created
     */
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

    /**
     * This controller method updates an existing task. It takes in the http request as param and returns a
     * HTTP response with status code, message and the Model object created.
     *
     * @param \Illuminate\Http\Request $request // Request coming from endpoint
     * @param int                      $id      // This is the ID of the task to be updated
     *
     * @return Illuminate\Http\Response // response returned which include the status code,
     * message and the Model object created
     */
    public function updateTask(Request $request, int $id): Response
    {
        $rules = array(
            'label' => ['nullable', 'string', 'max:191'],
            'sort_order' => ['nullable', 'integer'],
            'task_completed_status' => ['nullable', 'boolean'],
        );

        $data = request()->validate($rules);
        
        $task = Task::find($id);
        // $tt = Task::where('sort_order', '=', $data['sort_order'])->first();
        // dd($task, $tt);
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
