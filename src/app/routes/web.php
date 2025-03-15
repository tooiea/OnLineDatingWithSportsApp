<?php

use App\Http\Controllers\MyTeamController;
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
    Route::prefix('team')->name('temp_register.team.')->group(function () {
        // チーム作成 (仮登録)
        Route::get('/', [TempTeamRegisterController::class, 'index'])->name('index');
        Route::post('confirm', [TempTeamRegisterController::class, 'confirm'])->name('confirm');
        Route::post('complete', [TempTeamRegisterController::class, 'complete'])->name('complete');
        Route::post('back', [TempTeamRegisterController::class, 'back'])->name('back');

        // チーム参加 (仮登録)
        Route::prefix('join')->group(function () {
            Route::get('{invitation_code}', [TempTeamJoinController::class, 'index'])->name('join.index');
            Route::post('{invitation_code}/confirm', [TempTeamJoinController::class, 'confirm'])->name('join.confirm');
            Route::post('{invitation_code}/complete', [TempTeamJoinController::class, 'complete'])->name('join.complete');
            Route::post('{invitation_code}/back', [TempTeamJoinController::class, 'back'])->name('join.back');
        });
    });
});

Route::get('register/{token}', [TeamController::class, 'register'])->name('team.register');
Route::get('login',[UserLoginController::class, 'index'])->name('email_login.index');
Route::post('login',[UserLoginController::class, 'login'])->name('email_login.login');
Route::get('line/login',[LineLoginController::class, 'redirectTo'])->name('line.login');
Route::get('line/login/callback', [LineLoginController::class, 'callback'])->name('line.callback');
Route::get('google/login',[GoogleLoginController::class, 'redirectTo'])->name('google.login');
Route::get('google/login/callback', [GoogleLoginController::class, 'callback'])->name('google.callback');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth:user')->group(function () {
    Route::prefix('myteam')->name('myteam.')->group(function () {
        Route::get('/', [MyTeamController::class, 'index'])->name('index');
        Route::get('detail', [MyTeamController::class, 'detail'])->name('detail');
    });

    Route::prefix('teams')->name('team.')->group(function () {
        // チーム一覧
        Route::get('/', [TeamController::class, 'list'])->name('list');
        // チーム詳細
        Route::get('{team_id}', [MyTeamController::class, 'detail'])->name('detail');
        // チーム招待
        Route::get('{team_id}/invite_game', [TeamController::class, 'inviteGame'])->name('invite_game');
    });
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
