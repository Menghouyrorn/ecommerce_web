<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $per_page = $request->input('per_page', 10);
            $email = $request->input('email');
            $f_name = $request->input('f_name');
            $l_name = $request->input('l_name');
            $phone = $request->input('phone');

            $res = UserModel::query()
                ->when($email, fn(Builder $query) => $query->where('email', $email))
                ->when($f_name, fn(Builder $query) => $query->where('first_name', $f_name))
                ->when($l_name, fn(Builder $query) => $query->where('last_name', $l_name))
                ->when($phone, fn(Builder $query) => $query->where('phone', $phone))
                ->with('role.permission')
                ->paginate($per_page);
            return UserResource::collection($res);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $msg = json_encode($exception->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $check = UserModel::query()->where('id', $id);
            if ($check->count() > 0) {
                $check->update($request->all());
                return response()->json([
                    'data' => [
                        'message' => 'User updated successfully'
                    ]
                ]);
            } else {
                return response()->json([
                    'message' => 'User not found'
                ]);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $msg = json_encode($exception->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
