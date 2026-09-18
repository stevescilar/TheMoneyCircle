<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/transactions', [TransactionController::class, 'store']);
});