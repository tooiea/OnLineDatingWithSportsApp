<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class UserLoginController extends Controller
{
    /**
     * ログイン初期表示
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'routes' => [
                'home' => route('home'),
                'email_login' => route('email_login.login'),
                'password_request' => route('password.request'),
                'google_login' => route('google.login'),
                'line_login' => route('line.login'),
                'temp_register_team' => route('temp_register.team.index'),
            ]
        ]);
    }

    /**
     * ログイン処理
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('team.list', absolute: false));
    }

    /**
     * ログアウト処理
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login.index', absolute: false));
    }
}
