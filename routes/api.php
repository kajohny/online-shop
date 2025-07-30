<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class,'login']);

Route::get('/products', [ProductController::class,'index']);
Route::get('/products/{id}', [ProductController::class,'show']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);

    Route::get('orders', [OrderController::class, 'myOrders']);
    Route::get('orders/{id}', [OrderController::class, 'myOrder']);

    Route::post('logout', [AuthController::class, 'logout']);
});