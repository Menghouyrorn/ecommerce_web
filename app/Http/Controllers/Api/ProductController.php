<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $res = ProductModel::query()->get()->all();
            return response()->json($res);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_THROW_ON_ERROR);
            return response($msg, 500);
        }
    }
}
