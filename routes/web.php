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
});
require __DIR__.'/auth.php';
