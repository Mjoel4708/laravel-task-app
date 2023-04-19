<?php

namespace App\Traits;

use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

trait HandleErrorResponseTrait {
    public function handleErrorResponse(\Exception $exception) {
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 404);
        }
        
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 403);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'error' => $exception->errors()
            ], 422);
        }
        if ($exception instanceof \Illuminate\Database\QueryException) {
            return response()->json([
                'error' => 'Database query exception'
            ], 500);
        }
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 401);
        }
        if($exception instanceof TokenExpiredException) {
            return response()->json([
                'error' => 'Token expired'
            ], 401);
        }
        if($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json([
                'error' => 'Token invalid'
            ], 401);
        }
        if($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json([
                'error' => 'Token absent'
            ], 401);
        }
        return response()->json([
            'error' => $exception->getMessage()
        ], 500);
        
    }
}