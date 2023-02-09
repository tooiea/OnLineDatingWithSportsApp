<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

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
            $user = $this->user->where('email', $loggeInUserByGoogle->email)->first();
            // dd($loggeInUserByGoogle);

            // googleログインで新規登録
            if (is_null($user)) {
                $user = $this->user->create([
                    'name' => $loggeInUserByGoogle->name,
                    'email' => $loggeInUserByGoogle->email,
                    'google_id' => $loggeInUserByGoogle->id,
                ]);
            } else {
                // 既に登録されている
                if (is_null($user->google_login_id)) {
                    $user->google_login_id = $loggeInUserByGoogle->id;
                    $user->save();
                }
            }
            Auth::login($user);
            return redirect()->route('search.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
