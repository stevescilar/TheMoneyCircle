<?php

use App\Http\Controllers\CoachDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberDetailController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/coach-dashboard', [CoachDashboardController::class,'index'])->name('coach.dashboard');
    Route::get('/members/{member}', [MemberDetailController::class, 'show'])->name('members.show');
    Route::patch('/members/{member}/reflections/{reflection}/notes', [MemberDetailController::class, 'updateReflectionNotes'])
        ->name('members.reflections.notes');
    Route::patch('/members/{member}/debts/{debt}/notes', [MemberDetailController::class, 'updateDebtNotes'])
        ->name('members.debts.notes');
    Route::patch('/members/{member}/categories/{category}/notes', [MemberDetailController::class, 'updateCategoryNotes'])
        ->name('members.categories.notes');
    Route::patch('/members/{member}/savings-goals/{savingsGoal}/notes', [MemberDetailController::class, 'updateSavingsGoalNotes'])
        ->name('members.savings-goals.notes');
    Route::patch('/members/{member}/emergency-fund/notes', [MemberDetailController::class, 'updateEmergencyFundNotes'])
        ->name('members.emergency-fund.notes');
});
require __DIR__.'/auth.php';
