<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::match(['get', 'post'], '/current-user', 'currentUser');
            Route::get('/logout', 'logout');
        });
    });

    Route::prefix('product')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('role')->group(function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'store');
            Route::patch('/{role}', 'update');
            Route::delete('/{role}', 'destroy');
        });
    });

    Route::prefix('permission')->group(function () {
        Route::controller(PermissionController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'store');
            Route::delete('/{id}', 'destroy');
            Route::patch('/{id}', 'update');
        });
    });

    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'delete');
            Route::get('/{id}', 'show');
        });
    });

    Route::prefix('store')->group(function () {
        Route::controller(StoreController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'store');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
});

