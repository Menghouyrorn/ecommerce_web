<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class UserController extends Controller
{
    public function index()
    {
        try {

        }catch (Exception $e){
            Log::error($e->getMessage());
            $msg = json_encode($e->getMessage(),JSON_THROW_ON_ERROR);
            return response($msg,500);
        }
    }
}
