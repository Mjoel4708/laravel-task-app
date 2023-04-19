<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\HandleErrorResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use HandleErrorResponseTrait;
    /**
     * Create a new AuthController instance.
     * 
     * @return void
     */
    public function __contruct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]); // Use the auth middleware to protect the routes in this controller
    }

    /**
     * Get a JWT via given credentials.
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validated();
            $credentials = $request->only(['email', 'password']);
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    public function test(Request $request){
        $attributes = $request->all();
        return response()->json(['data' => $attributes]);
    }

    /**
     * Register a User.
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $attributes = $request->validated();
            $attributes['password'] = bcrypt($attributes['password']);
            session()->flash('success', 'User successfully registered');
            $user = User::create($attributes);
            $token = Auth::login($user);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }

    /**
     * Logout user (Revoke the token)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            Auth::logout();
            return response()->json(['message' => 'User successfully signed out']);
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }
    
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->respondWithToken(Auth::refresh());
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }
    
    /**
     * get user profile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(Auth::user());
        } catch (\Exception $e) {
            return $this->handleErrorResponse($e);
        }
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}