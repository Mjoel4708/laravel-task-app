<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Traits\HandleErrorResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    use HandleErrorResponseTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $taskStatuses = TaskStatus::all();
            return response()->json(['data' => $taskStatuses], 200);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $attributes = $request->validate([
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
            ]);
            $taskStatus = TaskStatus::create($attributes);
            return response()->json(['data' => $taskStatus], 201);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $taskStatus = TaskStatus::findOrFail($id);
            return response()->json(['data' => $taskStatus], 200);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $attributes = $request->validate([
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'The name field is required.',
                'name.string' => 'The name must be a string.',
                'name.max' => 'The name may not be greater than 255 characters.',
            ]);
            $taskStatus = TaskStatus::findOrFail($id);
            $taskStatus->update($attributes);
            $taskStatus->save();
            return response()->json(['data' => $taskStatus], 200);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $taskStatus = TaskStatus::findOrFail($id);
            $taskStatus->delete();
            return response()->json(['data' => $taskStatus], 200);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }
}