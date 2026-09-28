<?php

use App\Http\Controllers\CoachDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberDetailController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('coach.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\CoachCommunityController;

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

    // Community Operations Suite (Phase 2)
    Route::get('/coach/announcements', [CoachCommunityController::class, 'announcementsIndex'])->name('coach.announcements.index');
    Route::post('/coach/announcements', [CoachCommunityController::class, 'announcementsStore'])->name('coach.announcements.store');
    Route::patch('/coach/announcements/{announcement}/pin', [CoachCommunityController::class, 'announcementsTogglePin'])->name('coach.announcements.pin');
    Route::delete('/coach/announcements/{announcement}', [CoachCommunityController::class, 'announcementsDestroy'])->name('coach.announcements.destroy');

    Route::get('/coach/live-sessions', [CoachCommunityController::class, 'liveSessionsIndex'])->name('coach.live-sessions.index');
    Route::post('/coach/live-sessions', [CoachCommunityController::class, 'liveSessionsStore'])->name('coach.live-sessions.store');
    Route::delete('/coach/live-sessions/{session}', [CoachCommunityController::class, 'liveSessionsDestroy'])->name('coach.live-sessions.destroy');

    Route::get('/coach/resources', [CoachCommunityController::class, 'resourcesIndex'])->name('coach.resources.index');
    Route::post('/coach/resources', [CoachCommunityController::class, 'resourcesStore'])->name('coach.resources.store');
    Route::delete('/coach/resources/{resource}', [CoachCommunityController::class, 'resourcesDestroy'])->name('coach.resources.destroy');

    // Community Operations Suite (Phase 3: Q&A Desk & Wins Wall)
    Route::get('/coach/questions', [CoachCommunityController::class, 'questionsIndex'])->name('coach.questions.index');
    Route::get('/coach/questions/{question}', [CoachCommunityController::class, 'questionsShow'])->name('coach.questions.show');
    Route::post('/coach/questions/{question}/answers', [CoachCommunityController::class, 'questionsAnswerStore'])->name('coach.questions.answers.store');
    Route::patch('/coach/questions/{question}/resolve', [CoachCommunityController::class, 'questionsToggleResolve'])->name('coach.questions.resolve');
    Route::delete('/coach/questions/{question}', [CoachCommunityController::class, 'questionsDestroy'])->name('coach.questions.destroy');
    Route::delete('/coach/answers/{answer}', [CoachCommunityController::class, 'answersDestroy'])->name('coach.answers.destroy');

    Route::get('/coach/wins', [CoachCommunityController::class, 'winsIndex'])->name('coach.wins.index');
    Route::post('/coach/wins', [CoachCommunityController::class, 'winsStore'])->name('coach.wins.store');
    Route::post('/coach/wins/{win}/cheer', [CoachCommunityController::class, 'winsCheer'])->name('coach.wins.cheer');
    Route::delete('/coach/wins/{win}', [CoachCommunityController::class, 'winsDestroy'])->name('coach.wins.destroy');
});
require __DIR__.'/auth.php';


// APK Download Routes
Route::get("/downloads/TheMoneyCircle.apk", function () {
    $path = public_path("downloads/TheMoneyCircle.apk");
    if (!file_exists($path)) {
        $path = public_path("downloads/the-money-circle.apk");
    }
    if (!file_exists($path)) {
        abort(404, "The Money Circle Android APK package is currently being prepared. Please check back shortly.");
    }
    return response()->download($path, "TheMoneyCircle.apk", [
        "Content-Type" => "application/vnd.android.package-archive",
    ]);
})->name("download.apk");

Route::get("/downloads/the-money-circle.apk", function () {
    return redirect()->route("download.apk");
});

Route::get("/download", function () {
    return redirect("/#download");
})->name("download.page");
