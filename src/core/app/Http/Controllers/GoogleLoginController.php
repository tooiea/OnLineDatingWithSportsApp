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
                     // 新規のユーザ(メールアドレスも登録されていない)
                    $user = $userModel->create([
                        'name' => $loggedInUserByGoogle->name,
                        'email' => $loggedInUserByGoogle->email,
                        'google_login_id' => $loggedInUserByGoogle->id,
                        'last_login_time' => $now,
                    ]);
                } else {
                    $user->google_login_id = $loggedInUserByGoogle->id;
                    $user->last_login_time = $now;
                    $user->save();
                }
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
