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
Route::get('/products/{product}', [ProductController::class,'show']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);

    Route::get('/my-orders', [OrderController::class, 'myOrders']);
    Route::get('/my-order/{id}', [OrderController::class, 'myOrder']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('customers/{customer}', [CustomerController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);