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
            $userId = User::findOrFail(Auth::id())->id;
            $task = UserTask::where('id', $id)->where('user_id', $userId)->first();
            return response()->json(['data' => $task], 200);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserTaskRequest $request, string $id)
    {
        try {
            $attributes = $request->validated();
            $userId = User::findOrFail(Auth::id())->id;
            $task = UserTask::where('id', $id)->where('user_id', $userId)->first();
            $task->update($attributes);
            $task->save();
            return response()->json(['data' => $task], 200);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $userId = User::findOrFail(Auth::id())->id;
            $task = UserTask::where('id', $id)->where('user_id', $userId)->first();
            $task->delete();
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

}