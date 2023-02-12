<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchTeamController;
use App\Http\Controllers\TempTeamUsersController;
use App\Http\Controllers\TempUsersController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ログイン不要
Route::middleware('guest')->group(function () {
    Route::middleware('custom.cache.headers:no_store')->group(function () {

        // エラー画面(直アクセス等)

        // 仮登録(チーム作成)
        Route::get('tmp/team/user/register', [TempTeamUsersController::class, 'index'])->name('tmp_team_user.index');
        Route::post('tmp/team/user/register/confirm', [TempTeamUsersController::class, 'confirm'])->name('tmp_team_user.confirm');
        Route::post('tmp/team/user/register/back', function (Request $request) {
            $specifyFormRequestInputs = $request->session()->pull('temp_team_user');
            return redirect()->route('tmp_team_user.index')->withInput($specifyFormRequestInputs->getAll());
        })->name('tmp_team_user.back');
        Route::post('tmp/team/user/register/complete', [TempTeamUsersController::class, 'complete'])->name('tmp_team_user.complete');

        // 仮登録(チーム招待)
        Route::get('notvalid', [TempUsersController::class, 'failedInvitationCode'])->name('tempUsers.failed'); // 招待コードなし
        Route::get('tmp/user/register/{invitation_code}', [TempUsersController::class, 'index'])->name('tmp_user.index');
        Route::post('tmp/user/register/confirm', [TempUsersController::class, 'confirm'])->name('tmp_user.confirm');
        Route::post('tmp/user/register/back', function (Request $request) {
            $specifyFormRequestInputs = $request->session()->pull('temp_user');
            $values = $specifyFormRequestInputs->getAll();
            $invitation_code = $values['invitation_code'];  // url再セット用に取得
            return redirect()->route('tmp_user.index', $invitation_code)->withInput($values);
        })->name('tmp_user.back');
        Route::post('tmp/user/register/complete', [TempUsersController::class, 'complete'])->name('tmp_user.registered');

        // 本登録
        Route::get('error', [UsersController::class, 'errorRegister'])->name('users.error'); // エラー発生時
        Route::get('notvalid/token', [UsersController::class, 'failedToken'])->name('users.failed'); // トークンなし
        Route::get('register/user/{token}', [UsersController::class, 'index'])->name('users.index');
        Route::get('login', [LoginController::class, 'index'])->name('login.index');
        Route::post('login', [LoginController::class, 'login'])
                ->name('login');

        // googleログイン
        Route::get('google/login', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
        Route::get('google/login/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

        // googleログイン
        Route::get('line/login', [LineLoginController::class, 'redirectToLine'])->name('line.login');
        Route::get('line/login/callback', [LineLoginController::class, 'handleLineCallback']);
    });

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

    // ログイン後の検索画面
    Route::get('search/team', [SearchTeamController::class, 'index'])->name('search.index');

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

    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
