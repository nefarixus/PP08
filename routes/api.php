<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Важно: /products/count должен быть ДО /products/{id}
Route::get('/products/count', [AdminController::class, 'productsCount']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/user/library', [LibraryController::class, 'index']);
    Route::post('/library', [LibraryController::class, 'store']);

    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    // Маршруты только для администраторов
    Route::prefix('admin')->group(function () {
        Route::get('/products', [AdminController::class, 'products']);
        Route::post('/products', [AdminController::class, 'storeProduct']);
        Route::delete('/products/{id}', [AdminController::class, 'destroyProduct']);
        Route::post('/products/{id}/restore', [AdminController::class, 'restoreProduct']);
    });
});
