<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskStatusController;
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

Route::group(['middleware' => 'api', 'prefix' => 'auth/v1'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group(['middleware' => 'auth.jwt', 'prefix' => 'status/v1'], function () {
    Route::get('/', [TaskStatusController::class, 'index']);
    Route::post('/', [TaskStatusController::class, 'store']);
    Route::get('/{id}', [TaskStatusController::class, 'show']);
    Route::put('/{id}', [TaskStatusController::class, 'update']);
    Route::delete('/{id}', [TaskStatusController::class, 'destroy']);
});
//Route fallback
Route::fallback(function () {
    return response()->json([
        "status" => "failed",
        "message" => "Page not found, if the problem persists, contact info@task.com"
    ], 404);
});