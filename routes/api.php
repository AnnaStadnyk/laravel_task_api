<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\TaskStatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::middleware('guest:sanctum')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/task/statistics', TaskStatisticsController::class);

        Route::get('/task', [TaskController::class, 'index']);
        Route::post('/task', [TaskController::class, 'store']);
        Route::get('/task/{task}', [TaskController::class, 'show'])->can('edit', 'task');
        Route::put('/task/{task}', [TaskController::class, 'update'])->can('edit', 'task');
        Route::delete('/task/{task}', [TaskController::class, 'destroy'])->can('edit', 'task');
        Route::patch('/task/{task}/complete', [TaskController::class, 'complete'])->can('edit', 'task');
    });
});
