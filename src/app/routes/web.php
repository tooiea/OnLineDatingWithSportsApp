<?php

use App\Http\Controllers\Sns\GoogleLoginController;
use App\Http\Controllers\Sns\LineLoginController;
use App\Http\Controllers\TempTeamJoinController;
use App\Http\Controllers\TempTeamRegisterController;
use App\Http\Controllers\UserLoginController;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('temp_register')->group(function () {
    // チーム登録 (仮登録)
    Route::prefix('team')->group(function () {
        // チーム作成 (仮登録)
        Route::get('/', [TempTeamRegisterController::class, 'index'])->name('temp_register.team.index');
        Route::post('confirm', [TempTeamRegisterController::class, 'confirm'])->name('temp_register.team.confirm');
        Route::post('complete', [TempTeamRegisterController::class, 'complete'])->name('temp_register.team.complete');
        Route::post('back', [TempTeamRegisterController::class, 'back'])->name('temp_register.team.back');

        // チーム参加 (仮登録)
        Route::prefix('join')->group(function () {
            Route::get('/', [TempTeamJoinController::class, 'index'])->name('temp_register.team.join');
            Route::post('confirm', [TempTeamJoinController::class, 'confirm'])->name('temp_register.team.join.confirm');
            Route::post('complete', [TempTeamJoinController::class, 'complete'])->name('temp_register.team.join.complete');
            Route::post('back', [TempTeamJoinController::class, 'back'])->name('temp_register.team.join.back');
        });
    });
});

Route::get('register/{token}', [TeamController::class, 'register'])->name('team.register');
Route::get('login',[UserLoginController::class, 'index'])->name('email_login.index');
Route::post('login',[UserLoginController::class, 'login'])->name('email_login.login');
Route::get('line/login',[LineLoginController::class, 'redirectTo'])->name('line.login');
Route::get('line/login/callback', [LineLoginController::class, 'line.callback']);
Route::get('google/login',[GoogleLoginController::class, 'redirectTo'])->name('google.login');
Route::get('google/login/callback', [GoogleLoginController::class, 'google.callback']);


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('teams', [TeamController::class, 'list'])->name('team.list');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
