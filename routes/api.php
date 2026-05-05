<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([EnsureFrontendRequestsAreStateful::class])->group(function () {
    // Public routes (no auth required)
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
    
    // Public product routes (accessible without authentication)
    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
    Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show']);

    // Protected routes (auth required)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
        Route::get('/user', [App\Http\Controllers\UserController::class, 'show']);

        Route::get('/user/library', [App\Http\Controllers\LibraryController::class, 'index']);
        Route::post('/library', [App\Http\Controllers\LibraryController::class, 'store']);
        // TODO: Add routes for paid products and orders
    });
});