<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TenantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::apiResource('tenants', TenantController::class)
    ->except(['destroy']);

Route::patch(
    'tenants/{tenant}/activate',
    [TenantController::class, 'activate']
);

Route::patch(
    'tenants/{tenant}/suspend',
    [TenantController::class, 'suspend']
);

Route::middleware(['auth:sanctum', 'tenant'])->get('/tenant-context', function (Request $request) {
    return response()->json([
        'tenant' => $request->attributes->get('tenant'),
    ]);
});
