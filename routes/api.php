<?php

use Illuminate\Http\Request;
use App\Task;
use App\Http\Controllers\TaskController;

Route::group(
    ['prefix' => 'tasks'],
    function () {
        Route::get('/get-tasks', [TaskController::class, 'index']);
        Route::post('/add-task', [TaskController::class, 'addTask']);
        Route::put('/update-task/{id}', [TaskController::class, 'updateTask']);
    }
);
