<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserTokenRequest;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends BasesController
{
    /**
     * 仮ユーザ登録後のフォーム
     *
     * @param UserTokenRequest $request
     * @param string $token
     * @return void
     */
    public function index(UserTokenRequest $request, $token)
    {
        $tmpUserModel = new TempUser();
        $tmpUser = $tmpUserModel->getUserByToken($token);

        $user = new User();
        $user->where(['email' => $tmpUser->email])->update([
            'is_enabled' => CommonConstant::FLAG_ON,
        ]);

        // TODO チーム招待コードから、チームメンバーとして登録する

        return redirect()->route('users.complete');
    }

    /**
     * ユーザ本登録後の表示
     *
     * @return void
     */
    public function complete()
    {
        return view('users.index');
    }
}
