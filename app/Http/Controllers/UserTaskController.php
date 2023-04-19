<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTaskRequest;
use App\Models\User;
use App\Models\UserTask;
use App\Traits\HandleErrorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTaskController extends Controller
{
    use HandleErrorResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::with('userTasks')->findOrFail(Auth::id());
            $tasks = $user->userTasks->all();
            return response()->json(['data' => $tasks], 200);

        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
           
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserTaskRequest $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['user_id'] = Auth::id();
            $userTask = UserTask::create($attributes);
            return response()->json(['data' => $userTask], 201);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::with('userTasks')->findOrFail(Auth::id()); 
            $task = $user->user_tasks->where('id', $id)->first();
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserTaskRequest $request, string $id)
    {
        try {
            $attributes = $request->validated();
            $user = User::with('userTasks')->findOrFail(Auth::id()); 
            $task = $user->user_tasks->where('id', $id)->first();
            $task->update($attributes);
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::with('userTasks')->findOrFail(Auth::id()); 
            $task = $user->user_tasks->where('id', $id)->first();
            $task->delete();
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

}