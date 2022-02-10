<?php

use Illuminate\Http\Request;
use App\Task;
use App\Http\Controllers\TaskController;

Route::group(
    ['prefix' => 'tasks'],
    function () {
        Route::get(
            '/get-tasks',
            function (Request $request) {
                return Task::get();
            }
        );
        Route::post('/add-task', [TaskController::class, 'addTask']);
    }
);
