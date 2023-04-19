<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\UserTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Authentication
Route::group(['middleware' => 'api', 'prefix' => 'auth/v1'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
// Task Statuses
Route::group(['middleware' => 'auth.jwt', 'prefix' => 'status/v1'], function () {
    Route::get('/', [TaskStatusController::class, 'index']);
    Route::post('/', [TaskStatusController::class, 'store']);
    Route::get('/{id}', [TaskStatusController::class, 'show']);
    Route::put('/{id}', [TaskStatusController::class, 'update']);
    Route::delete('/{id}', [TaskStatusController::class, 'destroy']);
});
// Tasks
Route::group(['middleware' => 'auth.jwt', 'prefix' => 'tasks/v1'], function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});
// User Tasks
Route::group(['middleware' => 'auth.jwt', 'prefix' => 'user-tasks/v1'], function () {
    Route::get('/', [UserTaskController::class, 'index']);
    Route::post('/', [UserTaskController::class, 'store']);
    Route::get('/{id}', [UserTaskController::class, 'show']);
    Route::put('/{id}', [UserTaskController::class, 'update']);
    Route::delete('/{id}', [UserTaskController::class, 'destroy']);
});

//Route fallback
Route::fallback(function () {
    return response()->json([
        "status" => "failed",
        "message" => "Page not found, if the problem persists, contact info@task.com"
    ], 404);
});