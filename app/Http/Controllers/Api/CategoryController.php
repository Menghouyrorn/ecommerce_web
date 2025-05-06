<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $res = CategoryModel::query()->get()->all();
            return response()->json($res, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_decode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response()->json([
                'message' => $msg
            ], 500);
        }
    }
}
