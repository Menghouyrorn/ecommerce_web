<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $id = $request->input('id');
            $role = $request->input('role');
            $per_page = $request->query('per_page', 10);
            $res = RoleModel::query()
                ->when($id, fn(Builder $builder) => $builder->where('id', $id))
                ->when($role, fn(Builder $builder) => $builder->where('name', $role))
                ->with(['permission','user'])
                ->paginate($per_page);
            return RoleResource::collection($res);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function show(int $id)
    {
        try {
            $res = RoleModel::query()->with('permission')->find($id);
            return RoleResource::make($res);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'permission_id' => 'required|array'
            ]);

            $res = RoleModel::query()->create($request->all());
            $permission = $request->get('permission_id');
            foreach ($permission as $permission_id) {
                RolePermissionModel::query()->create([
                    'role_id' => $res->id,
                    'permission_id' => $permission_id
                ]);
            }
            return RoleResource::make($res);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'permission_id' => 'nullable|integer'
            ]);

            $role = RoleModel::query()->where('id', $id);
            if ($role->count() > 0) {
                $role->update($request->all());
                return response()->json([
                    'data' => [
                        'message' => 'Update Role Successfully'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'message' => 'Role Not Found !'
                    ]
                ]);
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $check = RoleModel::query()->where('id', $id);
            if ($check->count() > 0) {
                $check->delete();
                return response()->json([
                    'data' => [
                        'message' => 'Delete Role Successfully'
                    ]
                ]);
            } else {
                return response()->json([
                    'data' => [
                        'message' => 'Role Not Found'
                    ]
                ], 404);
            }

        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
