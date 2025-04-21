<?php

use App\Http\Controllers\ConsentGameInviteController;
use App\Http\Controllers\ConsentGameReplyController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\MyTeamController;
use App\Http\Controllers\Sns\GoogleLoginController;
use App\Http\Controllers\Sns\LineLoginController;
use App\Http\Controllers\TempTeamJoinController;
use App\Http\Controllers\TempTeamRegisterController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 認証不要
Route::middleware('custom_guest:user')->group(function () {
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
                Route::get('invalid', [TempTeamJoinController::class, 'invalid'])->name('join.invalid');
                Route::get('{invitation_code}', [TempTeamJoinController::class, 'index'])->name('join.index');
                Route::post('{invitation_code}/confirm', [TempTeamJoinController::class, 'confirm'])->name('join.confirm');
                Route::post('{invitation_code}/complete', [TempTeamJoinController::class, 'complete'])->name('join.complete');
                Route::post('{invitation_code}/back', [TempTeamJoinController::class, 'back'])->name('join.back');
            });
        });
    });

    // ユーザ本登録
    Route::get('register/user/error', [UsersController::class, 'errorRegister'])->name('user.error'); // エラー発生時
    Route::get('register/user/notvalid', [UsersController::class, 'failedToken'])->name('user.failed'); // トークンなし
    Route::get('register/user/{token}', [UsersController::class, 'index'])->name('user.register');

    // ログイン処理
    Route::get('login',[UserLoginController::class, 'index'])->name('login.index');
    Route::post('login',[UserLoginController::class, 'login'])->name('email_login.login');
    Route::get('line/login',[LineLoginController::class, 'redirectTo'])->name('line.login');
    Route::get('line/login/callback', [LineLoginController::class, 'callback'])->name('line.callback');
    Route::get('google/login',[GoogleLoginController::class, 'redirectTo'])->name('google.login');
    Route::get('google/login/callback', [GoogleLoginController::class, 'callback'])->name('google.callback');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 認証必要
Route::middleware('auth:user')->group(function () {
    // チームなしユーザ(チーム作成 or チーム参加)
    Route::prefix('new_team')->name('new_team.')->group(function() {
        Route::get('/', [TeamController::class, 'create'])->name('index');
        Route::post('confirm', [TeamController::class, 'confirm'])->name('confirm');
        Route::post('complete', [TeamController::class, 'creacompletete'])->name('complete');
    });

    Route::prefix('myteam')->name('myteam.')->group(function () {
        // チームプロフィール
        Route::get('/', [MyTeamController::class, 'index'])->name('index');
        Route::get('detail', [MyTeamController::class, 'detail'])->name('detail');
        Route::get('edit', [MyTeamController::class, 'edit'])->name('edit');
        Route::post('edit', [MyTeamController::class, 'update'])->name('update');

        // 招待された試合
        Route::prefix('consent_games/{consent_game_id}')->name('consent_game.')->group(function() {
            Route::get('/', [ConsentGameReplyController::class, 'detail'])->name('detail');
            Route::get('reply', [ConsentGameReplyController::class, 'index'])->name('reply.index');
            Route::post('reply/back', [ConsentGameReplyController::class, 'back'])->name('reply.back');
            Route::post('reply/confirm', [ConsentGameReplyController::class, 'confirm'])->name('reply.confirm');
            Route::post('reply/complete', [ConsentGameReplyController::class, 'complete'])->name('reply.complete');
            Route::post('reply/message', [ConsentGameReplyController::class, 'replyMessage'])->name('reply.message');
        });
    });

    Route::prefix('teams')->name('team.')->group(function () {
        // チーム一覧
        Route::get('/', [TeamController::class, 'list'])->name('list');

        // 招待する試合
        Route::prefix('{team_id}')->group(function() {
            // 招待詳細
            Route::get('/', [MyTeamController::class, 'detail'])->name('detail');

            // 試合の招待
            Route::prefix('invite_game')->name('invite_game.')->group(function () {
                Route::get('/', [ConsentGameInviteController::class, 'index'])->name('index');
                Route::post('back', [ConsentGameInviteController::class, 'back'])->name('back');
                Route::post('confirm', [ConsentGameInviteController::class, 'confirm'])->name('confirm');
                Route::post('complete', [ConsentGameInviteController::class, 'complete'])->name('complete');
            });
        });
    });

    // マイプロフィール
    Route::name('my-profile.')->group(function () {
        Route::get('my-profile', [MyProfileController::class, 'detail'])->name('detail');
        Route::get('my-profile/edit', [MyProfileController::class, 'edit'])->name('edit');
        Route::post('my-profile/edit', [MyProfileController::class, 'update'])->name('update');
    });

    Route::post('logout', [UserLoginController::class, 'logout'])->name('logout');
});
