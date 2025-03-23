<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * パスワード再設定
 */
class NewPasswordController extends Controller
{
    /**
     * パスワード入力画面
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * リクエストクラスを外出しに修正
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request)
    {
        // 入力された値で、password_resetsテーブルとusersテーブルを更新
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return redirect()->route('login')->with('new-pw.status', __($status));
    }
}
