<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\CheckoutController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/user/library', [LibraryController::class, 'index']);
    Route::post('/library', [LibraryController::class, 'store']);

    Route::post('/checkout', [CheckoutController::class, 'checkout']);
});
