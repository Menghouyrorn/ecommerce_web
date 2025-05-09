<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\StoreModel;
use App\Models\UserHasStore;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        try {
            $per_page = $request->input('per_page', 10);
            $store_no = $request->input('store_no');
            $store_name = $request->input('store_name');
            $store_address = $request->input('store_address');
            $store_phone = $request->input('store_phone');
            $store_email = $request->input('store_email');

            $store = StoreModel::query()
                ->when($store_no, fn(Builder $q) => $q->where('store_no', $store_no))
                ->when($store_name, fn(Builder $q) => $q->where('store_name', $store_name))
                ->when($store_address, fn(Builder $q) => $q->where('store_address', $store_address))
                ->when($store_phone, fn(Builder $q) => $q->where('store_phone', $store_phone))
                ->when($store_email, fn(Builder $q) => $q->where('store_email', $store_email))
                ->with('manager')
                ->with('employee')
                ->paginate($per_page);

            return StoreResource::collection($store);
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
                'store_name' => 'required|string',
                'store_address' => 'required|string',
                'store_phone' => 'required|string',
                'store_email' => 'string',
                'manager_id' => 'required|integer',
            ]);
            $store_no = $this->generateStoreNo();
            $request->merge([
                'store_no' => $store_no,
            ]);
            $create_store = StoreModel::query()->create($request->only('store_name', 'store_address', 'store_phone', 'store_email', 'store_no', 'manager_id'));
            UserHasStore::query()->create([
                'store_id' => $create_store->id,
                'user_id' => $request->manager_id
            ]);
            return StoreResource::make($create_store);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $check = StoreModel::query()->where('id', $id);
            if ($check->count() > 0) {
                $check->delete();
                return response()->json([
                    'message' => 'Record deleted successfully.'
                ]);
            } else {
                return response()->json([
                    'message' => 'Record not found.'
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $update = StoreModel::query()->where('id', $id);
            if ($update->count() > 0) {
                $update->update($request->all());
                return response()->json([
                    'message' => 'Record updated successfully.'
                ]);
            } else {
                return response()->json([
                    'message' => 'Record not found.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }

    private function generateStoreNo()
    {
        try {
            $has_store_no = StoreModel::query()->orderByRaw("CAST(SUBSTRING_INDEX(store_no,'-',-1) AS UNSIGNED) DESC")->first();
            $nextNumber = 1;
            if ($has_store_no) {
                $nextNumber = (int)explode('-', $has_store_no->store_no)[1] + 1;
            }

            $sort_type = "ST";
            $new_number = str_pad($nextNumber, 3, "0", STR_PAD_LEFT);
            $store_no = $sort_type . '-' . $new_number;
            return $store_no;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
