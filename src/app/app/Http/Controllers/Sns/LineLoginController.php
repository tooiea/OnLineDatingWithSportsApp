<?php

namespace App\Http\Controllers\Sns;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class LineLoginController extends Controller
{
    public function redirectTo()
    {
        return Socialite::driver('line')->redirect();
    }

    public function callback()
    {
        try {
            $loggeInUserByLine = Socialite::driver('line')->user();
            $user = User::where('email', $loggeInUserByLine->email)->first();
            $now = CarbonImmutable::now();

            // TODO LINEログインした場合に、メールアドレスがない想定がないためケースを追加
            // メールアドレスが登録されていないときに、このまま登録可能かを確認

            // Lineログインで新規登録
            if (is_null($user)) {
                $userModel = new User();
                $user = $userModel->create([
                    'name' => $loggeInUserByLine->name,
                    'email' => $loggeInUserByLine->email,
                    'line_login_id' => $loggeInUserByLine->id,
                    'last_login_at' => $now,
                ]);
            } else {
                // 既に登録されている
                if (is_null($user->line_login_id)) {
                    $user->line_login_id = $loggeInUserByLine->id;
                }
                $user->last_login_at = $now;
                $user->save();
            }
            Auth::guard('user')->login($user);
            return redirect()->intended(route('team.list', absolute: false));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
