<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * パスワードリセット
 */
class PasswordResetLinkController extends Controller
{
    /**
     * 入力画面表示
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * メールアドレスが登録されている場合、リセットメールを送信する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ResetPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('pw-forgot.status', __($status));
    }
}
