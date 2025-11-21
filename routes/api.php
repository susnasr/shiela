<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

// PUBLIC ROUTES — MUST BE FIRST
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product:slug}', [ProductController::class, 'show']);

// PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn() => auth()->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{product}', [CartController::class, 'add']);
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove']);
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update']);
});
