<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'message' => 'product api test',
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(), JSON_ERROR_RECURSION);
            return response($msg, 500);
        }
    }
}
