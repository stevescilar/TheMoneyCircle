<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\DebtController;
use App\Http\Controllers\Api\EmergencyFundController;
use App\Http\Controllers\Api\InvestmentController;
use App\Http\Controllers\Api\MonthlyReflectionController;
use App\Http\Controllers\Api\SavingsGoalController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);

    Route::get('/savings-goals', [SavingsGoalController::class, 'index']);
    Route::post('/savings-goals', [SavingsGoalController::class, 'store']);
    Route::post('/savings-goals/{savingsGoal}/contribute', [SavingsGoalController::class, 'contribute']);
    Route::delete('/savings-goals/{savingsGoal}', [SavingsGoalController::class, 'destroy']);

    Route::get('/debts', [DebtController::class, 'index']);
    Route::post('/debts', [DebtController::class, 'store']);
    Route::put('/debts/{debt}', [DebtController::class, 'update']);
    Route::delete('/debts/{debt}', [DebtController::class, 'destroy']);
    Route::post('/debts/{debt}/payments', [DebtController::class, 'recordPayment']);

    Route::get('/investments', [InvestmentController::class, 'index']);
    Route::post('/investments', [InvestmentController::class, 'store']);
    Route::put('/investments/{investment}', [InvestmentController::class, 'update']);
    Route::delete('/investments/{investment}', [InvestmentController::class, 'destroy']);
    Route::post('/investments/{investment}/contributions', [InvestmentController::class, 'contribute']);
    Route::get('/investments/{investment}/contributions', [InvestmentController::class, 'contributions']);

    Route::get('/emergency-fund', [EmergencyFundController::class, 'show']);
    Route::post('/emergency-fund', [EmergencyFundController::class, 'store']);
    Route::put('/emergency-fund', [EmergencyFundController::class, 'update']);
    Route::post('/emergency-fund/contribute', [EmergencyFundController::class, 'contribute']);

    Route::get('/monthly-reflections', [MonthlyReflectionController::class, 'index']);
    Route::post('/monthly-reflections', [MonthlyReflectionController::class, 'store']);
});