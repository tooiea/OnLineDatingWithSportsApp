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
            $user = User::where('email', $loggeInUserByLine->email)->first();
            $now = Carbon::now();

            // TODO LINEログインした場合に、メールアドレスがない想定がないためケースを追加
            // メールアドレスが登録されていないときに、このまま登録可能かを確認

            // Lineログインで新規登録
            if (is_null($user)) {
                $userModel = new User();
                $user = $userModel->create([
                    'name' => $loggeInUserByLine->name,
                    'email' => $loggeInUserByLine->email,
                    'line_login_id' => $loggeInUserByLine->id,
                    'last_login_time' => $now,
                ]);
            } else {
                // 既に登録されている
                if (is_null($user->line_login_id)) {
                    $user->line_login_id = $loggeInUserByLine->id;
                }
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
