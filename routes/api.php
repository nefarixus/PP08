<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    // Public routes
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

    // Public product routes
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
    Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
        Route::get('/user', [App\Http\Controllers\UserController::class, 'show']);

        Route::get('/user/library', [App\Http\Controllers\LibraryController::class, 'index']);
        Route::post('/library', [App\Http\Controllers\LibraryController::class, 'store']);

        Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout']);
    });
});
