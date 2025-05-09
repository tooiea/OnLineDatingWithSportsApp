<?php
declare(strict_types=1);
namespace App\Http\Controllers\Sns;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;

class GoogleLoginController extends Controller
{
    /**
     * リダイレクト
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
     */
    public function redirectTo(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * コールバック処理
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function callback(): HttpRedirectResponse
    {
        try {
            $loggedInUserByGoogle = Socialite::driver('google')->user();

            // google_idでユーザの存在確認(ユーザの上書き)
            $user = User::where('google_login_id', $loggedInUserByGoogle->id)->first();
            $now = CarbonImmutable::now();

            // 初めてgoogleログインしたとき
            if (empty($user)) {
                $user = User::where('email', $loggedInUserByGoogle->email)->first();
                $userModel = new User();
                // googleログインしたときに同一メールアドレスが存在している
                if (empty($user)) {
                     // 新規のユーザ(メールアドレスも登録されていない)
                    $user = $userModel->create([
                        'name' => $loggedInUserByGoogle->name,
                        'email' => $loggedInUserByGoogle->email,
                        'google_login_id' => $loggedInUserByGoogle->id,
                        'last_login_at' => $now,
                    ]);
                } else {
                    $user->google_login_id = $loggedInUserByGoogle->id;
                    $user->last_login_at = $now;
                    $user->save();
                }
            } else {
                // 既に登録されている(ログイン日時のみ更新)
                $user->last_login_at = $now;
                $user->save();
            }
            Auth::guard('user')->login($user);
            return redirect()->intended(route('team.list', absolute: false));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('login.index')->with('status', 'Googleログインに失敗しました。');
        }
    }
}
