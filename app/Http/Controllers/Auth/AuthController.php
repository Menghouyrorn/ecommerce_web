<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\UserModel;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;

class AuthController extends Controller
{
    public function currentUser()
    {
        try {
            return response()->json(
                [
                    'current_user' => Auth::user()
                ]
                , 202);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $msg = json_encode($exception->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $key = $request->ip();
            $limit = RateLimiter::tooManyAttempts($key, 3);
            if ($limit) {
                $seconds = RateLimiter::availableIn($key);
                $minutes = $seconds / 60;
                return response()->json([
                    'message' => 'You may try again in ' . number_format($minutes) . ' Minutes'
                ], 429);
            }
            $check_user = UserModel::query()->where('password', $request->password)->first();
            if (!$check_user) {
                RateLimiter::hit($key);
                return response()->json([
                    'message' => 'Password or Email is incorrect!Please check again! thank'
                ], 404);

            }
            $token = $check_user->createToken('TOKEN_NAME')->plainTextToken;
            RateLimiter::clear($request->ip());
            return response()->json([
                'token' => $token,
            ], 202);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response()->json($msg, 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'f_name' => 'required|string',
                'l_name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string',
            ]);
            $hash_password = Hash::make($request->password);
            $request->merge(['password' => $hash_password]);
            UserModel::query()->create($request->all());
            return response()->json([
                'message' => 'User registered successfully!'
            ], 202);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json([
                'message' => 'User logged out successfully!'
            ], 202);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $msg = json_encode($exception->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
