<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\TempUsersController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ログイン不要
Route::middleware('guest')->group(function () {
    // 仮ユーザ登録
    Route::get('tmp/user/register', [TempUsersController::class, 'index'])->name('tmp_user.index');
    Route::post('tmp/user/register/confirm', [TempUsersController::class, 'confirm'])->name('tmp_user.confirm');
    Route::post('tmp/user/register/complete', [TempUsersController::class, 'complete'])->name('tmp_user.registered');

    // 本登録
    Route::get('notvalid/token', [UsersController::class, 'failedToken'])->name('users.failed'); // トークンなし
    Route::get('register/user/{token}', [UsersController::class, 'index'])->name('users.index');
    Route::get('login', [UsersController::class, 'login'])->name('users.login');
    Route::post('login', [UsersController::class, 'login'])
                ->name('login');

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //             ->name('login');

    // Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

// ログイン認証必須
Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
