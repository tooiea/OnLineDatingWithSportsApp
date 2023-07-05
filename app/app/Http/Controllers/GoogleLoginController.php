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
            Log::info($loggedInUserByGoogle->name);

            // google_idでユーザの存在確認(ユーザの上書き)
            $user = User::where('google_login_id', $loggedInUserByGoogle->id)->first();
            $now = Carbon::now();

            // 初めてgoogleログインしたとき
            if (empty($user)) {
                $user = User::where('email', $loggedInUserByGoogle->email)->first();

                // ユーザ登録されていない
                if (empty($user)) {
                    // ユーザ新規登録
                    $userModel = new User();
                    $userModel->name = $loggedInUserByGoogle->name;
                    $userModel->email = $loggedInUserByGoogle->email;
                    $userModel->google_login_id = $loggedInUserByGoogle->id;
                    $userModel->last_login_time = $now;
                    $userModel->save();

                    Auth::login($userModel);

                    return redirect()->route('tmp_sns_top.index');
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
