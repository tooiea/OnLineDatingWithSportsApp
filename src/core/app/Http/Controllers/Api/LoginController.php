<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\ApiBaseResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{

    // モバイルアプリケーションがトークンを使用してアプリケーションにAPIリクエストを行う場合、
    // AuthorizationヘッダのトークンをBearerトークンとして渡す必要があります。

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $data = [
            'status' => self::STATUS_400,
            'message' => __('passwords.user'),
            'data' => []
        ];

        // ログインOK
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken($user->name);
            $data = [
                'status' => self::STATUS_200,
                'message' => __('user_messages.success.login'),
                'data'  => [
                    'token' => $token->plainTextToken
                ]
            ];

            return new ApiBaseResource($data);
        }

        return new ApiBaseResource($data);
    }
}
