<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Tasks;
use App\Models\User;
use App\Traits\HandleErrorResponseTrait;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use HandleErrorResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = Tasks::all();
            return response()->json(['data' => $tasks], 200);

        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
           
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        try {
            $attributes = $request->validated();
            $userTask = Tasks::create($attributes);
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
            $task = Tasks::findOrFail($id);
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {
        try {
            $attributes = $request->validated();
            $task = Tasks::findOrFail($id);
            $task->update($attributes);
            $task->save();
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
            $task = Tasks::findOrFail($id);
            $task->delete();
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

}