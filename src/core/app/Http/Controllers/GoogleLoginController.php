<?php

namespace App\Http\Controllers;

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
            $loggeInUserByGoogle = Socialite::driver('google')->user();
            $user = User::where('email', $loggeInUserByGoogle->email)->first();
            $now = Carbon::now();

            // googleログインで新規登録
            if (is_null($user)) {
                $userModel = new User();
                $user = $userModel->create([
                    'name' => $loggeInUserByGoogle->name,
                    'email' => $loggeInUserByGoogle->email,
                    'google_login_id' => $loggeInUserByGoogle->id,
                    'last_login_time' => $now,
                ]);
            } else {
                // 既に登録されている
                if (is_null($user->google_login_id)) {
                    $user->google_login_id = $loggeInUserByGoogle->id;
                }
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
