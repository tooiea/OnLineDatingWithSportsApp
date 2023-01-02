<?php

use App\Http\Controllers\TempUsersController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 仮ユーザ登録
Route::get('tmp/user/register', [TempUsersController::class, 'index'])->name('tmp_user.index');
Route::post('tmp/user/register/complete', [TempUsersController::class, 'complete'])->name('tmp_user.registered');

// 本登録
Route::get('veryfy/user/{token}', [UsersController::class, 'index'])->name('user.index');
