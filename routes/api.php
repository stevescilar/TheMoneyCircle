<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\DebtController;
use App\Http\Controllers\Api\EmergencyFundController;
use App\Http\Controllers\Api\InvestmentController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\MonthlyReflectionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SavingsGoalController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/app/version', function () {
    return response()->json([
        'latest_version' => '1.0.1',
        'latest_build' => 2,
        'minimum_required_version' => '1.0.0',
        'update_url' => 'https://microsilsystem.co.ke/downloads/tmc-app.apk',
        'release_notes' => "• Member income visibility and net cashflow tracking\n• Edit monthly reflections\n• Member profile management and password change\n• Secure email verification and account activation",
        'force_update' => false,
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    Route::post('/email/verify', [AuthController::class, 'verifyEmail']);
    Route::post('/email/resend', [AuthController::class, 'resendVerificationCode']);
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
    Route::put('/monthly-reflections/{monthlyReflection}', [MonthlyReflectionController::class, 'update']);

    Route::get('/community/announcements', [CommunityController::class, 'announcements']);
    Route::get('/community/live-sessions', [CommunityController::class, 'liveSessions']);
    Route::get('/community/resources', [CommunityController::class, 'resources']);
    Route::get('/community/wins', [CommunityController::class, 'wins']);
    Route::post('/community/wins', [CommunityController::class, 'storeWin']);
    Route::post('/community/wins/{id}/cheer', [CommunityController::class, 'cheerWin']);
    Route::get('/community/questions', [CommunityController::class, 'questions']);
    Route::post('/community/questions', [CommunityController::class, 'storeQuestion']);
    Route::get('/community/questions/{id}', [CommunityController::class, 'questionDetails']);
    Route::post('/community/questions/{id}/answers', [CommunityController::class, 'storeAnswer']);
    Route::post('/community/answers/{id}/upvote', [CommunityController::class, 'upvoteAnswer']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
});