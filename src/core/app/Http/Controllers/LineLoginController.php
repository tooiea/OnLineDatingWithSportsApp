<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class LineLoginController extends Controller
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
        return Socialite::driver('ling')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $loggeInUserByLine = Socialite::driver('line')->user();
            $user = $this->user->where('email', $loggeInUserByLine->email)->first();
            // dd($loggeInUserByGoogle);

            // googleログインで新規登録
            if (is_null($user)) {
                $user = $this->user->create([
                    'name' => $loggeInUserByLine->name,
                    'email' => $loggeInUserByLine->email,
                    'google_id' => $loggeInUserByLine->id,
                ]);
            } else {
                // 既に登録されている
                if (is_null($user->line_login_id)) {
                    $user->line_login_id = $loggeInUserByLine->id;
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
