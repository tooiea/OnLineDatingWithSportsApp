<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

/**
 * LINEでログイン
 */
class LineLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToLine()
    {
        return Socialite::driver('line')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleLineCallback()
    {
        try {
            $loggeInUserByLine = Socialite::driver('line')->user();
            $user = User::where('line_login_id', $loggeInUserByLine->id)->first();
            $now = Carbon::now();

            // TODO LINEログインした場合に、メールアドレスがない想定がないためケースを追加
            // メールアドレスが登録されていないときに、このまま登録可能かを確認

            // Lineログインで新規登録
            if (is_null($user)) {
                $user = User::where('email', $loggeInUserByLine->email)->first();

                // メールアドレス, line_idの登録情報がない
                if (empty($user)) {
                    return redirect()->route('login.index')->withErrors([
                        'sns_login' => __('validation.custom.user.line')
                    ]);
                }
                // 同一メールアドレスが存在する
                $user->line_login_id = $loggeInUserByLine->id;
                $user->last_login_time = $now;
                $user->save();
            } else {
                // 既に登録されている
                $user->last_login_time = $now;
                $user->save();
            }
            Auth::login($user);
            return redirect()->route('team.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
