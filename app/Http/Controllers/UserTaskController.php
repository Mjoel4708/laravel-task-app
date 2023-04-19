<?php

namespace App\Http\Controllers;

use App\Traits\HandleErrorResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    use HandleErrorResponseTrait;
    
    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $tasks = $user->userTasks->get();
            return response()->json(['data' => $tasks], 200);

        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
           
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = Auth::user();
            $task = $user->userTasks->findOrFail($id);
            return response()->json(['data' => $task], 200);
        } catch (\Throwable $th) {
            return $this->handleErrorResponse($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }

}