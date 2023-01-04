<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserTokenRequest;
use Illuminate\Http\Request;

class UsersController extends BasesController
{
    /**
     * 仮ユーザ登録後のフォーム
     *
     * @param UserTokenRequest $request
     * @param string $token
     * @return void
     */
    public function index(UserTokenRequest $request, $token)
    {
        return view('users.index', compact('token'));
    }

    public function confirm(UserFormRequest $request)
    {
        $values = $request->all();
        var_dump($values);
        return view('users.confirm');
    }
}
