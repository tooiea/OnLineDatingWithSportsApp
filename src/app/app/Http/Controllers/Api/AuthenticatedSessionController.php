<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\SuccessAuthenticateResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function login(LoginRequest $request)
    {
        // 認証処理
        $request->authenticate();
        $user = User::where('email', $request->email)->first();
        return new SuccessAuthenticateResource($user);
    }

    public function logout()
    {

    }
}
