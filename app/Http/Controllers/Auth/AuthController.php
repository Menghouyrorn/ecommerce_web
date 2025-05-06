<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $check_user = UserModel::query()->where('email', $request->email)->first();
            if (!$check_user) {
                return response()->json([
                    'message' => 'User not found!'
                ], 404);
            }

            $token = $check_user->createToken('TOKEN_NAME')->plainTextToken;
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

    public function logout()
    {
        try {
            Auth::logout();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $msg = json_encode($exception->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
