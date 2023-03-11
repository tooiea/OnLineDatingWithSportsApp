<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends AuthenticatedSessionController
{
    /**
     * ログインフォーム
     *
     * @return void
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * ログインチェック
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('team.index');
        }

        return back()->withErrors([
            'email' => __('validation.password'),
        ]);
    }
}
