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
        $now = Carbon::now();
        try {
            $loggeInUserByLine = Socialite::driver('line')->user();
            $user = User::where('line_login_id', $loggeInUserByLine->id)->first();

            // Lineログインで新規登録
            if (empty($user)) {
                $user = User::where('email', $loggeInUserByLine->email)->first();

                // ユーザ登録されていない
                if (empty($user)) {
                    // ユーザ新規登録
                    $userModel = new User();
                    $userModel->create([
                        'name' => $loggeInUserByLine->name,
                        'email' => $loggeInUserByLine->email,
                        'line_login_id' => $loggeInUserByLine->id,
                        'last_login_time' => $now,
                    ]);
                    Auth::login($userModel);
                    Log::info('koko?');
                    return redirect()->route('tmp_sns_top.index');
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
            $log = sprintf('logged_time:%s, email:%s', $now->format('Y-m-d-G:i:s'), $loggeInUserByLine->email);
            Log::info($log);
            Auth::login($user);
            return redirect()->route('team.index');
        } catch (Exception $e) {
            $log = sprintf('time:%s, email:%s', $now->format('Y-m-d-G:i:s'), $loggeInUserByLine->email);
            Log::error($e->getMessage());
            Log::error('email: ' . $loggeInUserByLine->email);
            throw $e;
        }
    }
}
