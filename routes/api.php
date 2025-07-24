<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\AuthController;

Route::apiResource('customers', CustomerController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orderItems', OrderItemController::class);

Route::get('/categories-with-children', [CategoryController::class, 'indexWithChildren']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);
});