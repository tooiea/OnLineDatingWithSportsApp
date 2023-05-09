<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * パスワードリセット
 */
class PasswordResetLinkController extends Controller
{
    /**
     *入力画面表示
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * メールアドレスが登録されている場合、リセットメールを送信する
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
