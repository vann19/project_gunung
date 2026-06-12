<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Prefix: /api
| Semua route di sini otomatis mendapat prefix /api
|--------------------------------------------------------------------------
*/

// ============================================
// Public Routes (tanpa autentikasi)
// ============================================
Route::prefix('v1')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login',    [AuthController::class, 'login']);
    });

    // Health check
    Route::get('ping', fn() => response()->json([
        'status'  => true,
        'message' => 'API is running 🚀',
        'version' => 'v1',
        'time'    => now()->toDateTimeString(),
    ]));

    // ============================================
    // Protected Routes (butuh token Sanctum)
    // ============================================
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('profile', [AuthController::class, 'profile']);
            Route::post('logout', [AuthController::class, 'logout']);
        });

        // Tambahkan route lain di sini...
        // Route::apiResource('products', ProductController::class);
        // Route::apiResource('orders', OrderController::class);
    });
});
