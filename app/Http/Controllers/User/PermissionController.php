<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\PermissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $per_page = $request->input('per_page', 10);
            $res = PermissionModel::query()
                ->with('role')
                ->paginate($per_page);
            return PermissionResource::collection($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function show(int $id)
    {
        try {
            $res = PermissionModel::query()->with('role')->find($id);
            return new PermissionResource($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'permission' => 'required|string'
            ]);

            $res = PermissionModel::query()->create($request->all());
            return PermissionResource::make($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $check = PermissionModel::query()->where('id', $id);
            if ($check->count() > 0) {
                $check->delete();
                return response()->json([
                    'data' => [
                        'message' => 'Permission Deleted Successfully'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'message' => 'Permission Not Found'
                    ]
                ]);
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $res = PermissionModel::query()->where('id', $id);
            if ($res->count() > 0) {
                $res->update($request->all());
                return response()->json([
                    'data' => [
                        'message' => 'Permission Updated Successfully'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'message' => 'Permission Not Found'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
