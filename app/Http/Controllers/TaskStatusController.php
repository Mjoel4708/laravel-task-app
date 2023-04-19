<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Traits\HandleErrorResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    use HandleErrorResponseTrait;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $attributes = $request->all();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}