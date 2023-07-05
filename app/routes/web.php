<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BasesController;
use App\Http\Controllers\ConsentGamesController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchTeamController;
use App\Http\Controllers\TeamsController;
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

        // エラー画面(チームへ招待)
        Route::get('notvalid', [TempUsersController::class, 'failedInvitationCode'])->name('tempUsers.failed'); // 招待コードなし

        // 仮ユーザ登録関連
        Route::prefix('tmp')->group(function () {
            // 仮登録(チーム作成)
            Route::get('/register/team', [TempTeamUsersController::class, 'index'])->name('tmp_team_user.index');
            Route::post('/register/team/confirm', [TempTeamUsersController::class, 'confirm'])->name('tmp_team_user.confirm');
            Route::post('/register/team/back', function (Request $request) {
                $specifyFormRequestInputs = $request->session()->pull('temp_team_user');
                return redirect()->route('tmp_team_user.index')->withInput($specifyFormRequestInputs->getAll());
            })->name('tmp_team_user.back');
            Route::post('/register/team/complete', [TempTeamUsersController::class, 'complete'])->name('tmp_team_user.complete');

            // 仮登録(チーム招待)
            Route::get('/register/join/{invitation_code}', [TempUsersController::class, 'index'])->name('tmp_user.index');
            Route::post('/register/join/confirm', [TempUsersController::class, 'confirm'])->name('tmp_user.confirm');
            Route::post('/register/join/back', function (Request $request) {
                $specifyFormRequestInputs = $request->session()->pull('temp_user');
                $values = $specifyFormRequestInputs->getAll();
                $invitation_code = $values['invitation_code'];  // url再セット用に取得
                return redirect()->route('tmp_user.index', $invitation_code)->withInput($values);
            })->name('tmp_user.back');
            Route::post('/register/join/complete', [TempUsersController::class, 'complete'])->name('tmp_user.registered');


            // 初回ログインがSNSログインでチームを作る
            Route::get('/sns/register/team', [TempTeamUsersController::class, 'teamCreate'])->name('tmp_sns_create.index');
            Route::post('/sns/register/team/confirm', [TempTeamUsersController::class, 'teamCreateConfirm'])->name('tmp_sns_create.confirm');
            Route::post('/sns/register/team/back', function (Request $request) {
                $specifyFormRequestInputs = $request->session()->pull('temp_user');
                $values = $specifyFormRequestInputs->getAll();
                $invitation_code = $values['invitation_code'];  // url再セット用に取得
                return redirect()->route('tmp_user.index', $invitation_code)->withInput($values);
            })->name('tmp_sns_create.back');
            Route::post('/sns/register/team/complete', [TempTeamUsersController::class, 'teamCreateComplete'])->name('tmp_sns_create.complete');
        });

        // 本登録
        Route::get('error', [UsersController::class, 'errorRegister'])->name('users.error'); // エラー発生時
        Route::get('notvalid/token', [UsersController::class, 'failedToken'])->name('users.failed'); // トークンなし
        Route::get('register/user/{token}', [UsersController::class, 'index'])->name('users.index');
        Route::get('login', [LoginController::class, 'index'])->name('login.index');
        Route::post('login', [LoginController::class, 'login'])->name('login');

        // googleログイン
        Route::get('google/login', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
        Route::get('google/login/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

        // googleログイン
        Route::get('line/login', [LineLoginController::class, 'redirectToLine'])->name('line.login');
        Route::get('line/login/callback', [LineLoginController::class, 'handleLineCallback']);
    });

    // パスワードリセット(メール送信まで)
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // 送信されたリンクからパスワードを再設定
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// ログイン認証必須
Route::middleware('auth')->group(function () {

    // ログイン後の検索画面
    Route::get('search/team', [SearchTeamController::class, 'index'])->name('search.index');

    // チーム関連
    Route::prefix('team')->group(function () {
        Route::get('/profile/top', [TeamsController::class, 'index'])->name('team.index');
        Route::get('/profile/detail', [TeamsController::class, 'detail'])->name('team.detail');
        Route::get('/profile/edit', [TeamsController::class, 'edit'])->name('team.edit');
        Route::put('/profile/edit', [TeamsController::class, 'update'])->name('team.update');
    });

    // 試合の招待
    Route::middleware('custom.cache.headers:no_store')->group(function () {

        // 仮ユーザ登録関連
        Route::prefix('tmp')->group(function () {
            // 初回ログインがSNSログインの場合、トップページを表示 teamRegister.top
            Route::get('/sns/register', [BasesController::class, 'teamCreateTop'])->name('tmp_sns_top.index');

            // 初回ログインがSNSログインでチームに参加
            Route::get('/sns/register/join', [TempUsersController::class, 'join'])->name('tmp_sns_join.index');
            Route::post('/sns/register/join/confirm', [TempUsersController::class, 'joinConfirm'])->name('tmp_sns_join.confirm');
            Route::post('/sns/register/join/complete', [TempUsersController::class, 'joinComplete'])->name('tmp_sns_join.complete');
        });

        // consent
        Route::prefix('consent')->group(function () {
            // チーム関連
            Route::prefix('team')->group(function () {
                // チームへ招待する
                Route::get('/{invitation_code}', [ConsentGamesController::class, 'index'])->name('consent.index');
                Route::post('/confirm', [ConsentGamesController::class, 'confirm'])->name('consent.confirm');
                Route::post('/back', function (Request $request) {
                    $specifyFormRequestInputs = $request->session()->pull('consent_team');
                    $values = $specifyFormRequestInputs->getAll();
                    $invitation_code = $values['invitation_code'];  // url再セット用に取得
                    return redirect()->route('consent.index', $invitation_code)->withInput($values);
                })->name('consent.back');
                Route::post('/complete', [ConsentGamesController::class, 'complete'])->name('consent.complete');
            });

            // 返信関連
            Route::prefix('reply')->group(function () {
                // 招待に対する返信
                Route::get('/{consent_game_id}', [ConsentGamesController::class, 'reply'])->name('reply.index');
                Route::post('/confirm', [ConsentGamesController::class, 'confirmReply'])->name('reply.confirm');
                Route::post('/back', function (Request $request) {
                    $specifyFormRequestInputs = $request->session()->pull('consent_reply');
                    $values = $specifyFormRequestInputs->getAll();
                    $consent_game_id = $request->session()->pull('consent_game_id');  // url再セット用に取得
                    return redirect()->route('reply.index', $consent_game_id)->withInput($values);
                })->name('reply.back');
                Route::post('/complete', [ConsentGamesController::class, 'completeReply'])->name('reply.complete');

                // 招待とメール返信の詳細
                Route::get('/detail/{consent_game_id}', [ConsentGamesController::class, 'detail'])->name('reply.detail');

                // メッセージ返信
                Route::post('/message', [ConsentGamesController::class, 'replyMessage'])->name('reply.message');
            });
        });
    });

    // ログアウト
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
    //             ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('verification.verify');

    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //             ->middleware('throttle:6,1')
    //             ->name('verification.send');

    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //             ->name('password.confirm');

    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
});
