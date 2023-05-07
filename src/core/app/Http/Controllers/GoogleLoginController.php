<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

/**
 * googleでログイン
 */
class GoogleLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $loggedInUserByGoogle = Socialite::driver('google')->user();

            // google_idでユーザの存在確認(ユーザの上書き)
            $user = User::where('google_login_id', $loggedInUserByGoogle->id)->first();
            $now = Carbon::now();

            // 初めてgoogleログインしたとき
            if (empty($user)) {
                $user = User::where('email', $loggedInUserByGoogle->email)->first();
                $userModel = new User();
                // googleログインしたときに同一メールアドレスが存在している
                if (empty($user)) {
                    // TODO チーム新規登録、チームへ登録の画面へ遷移する

                    // メールアドレス, google_idの登録情報がない
                    return redirect()->route('login.index')->withErrors([
                        'sns_login' => __('validation.custom.user.google')
                    ]);
                }
                // メールアドレスが存在している
                $user->google_login_id = $loggedInUserByGoogle->id;
                $user->last_login_time = $now;
                $user->save();
            } else {
                // 既に登録されている(ログイン日時のみ更新)
                $user->last_login_time = $now;
                $user->save();
            }
            Auth::login($user);
            return redirect()->route('search.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
