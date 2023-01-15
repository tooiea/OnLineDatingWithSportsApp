<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;

class LoginController extends AuthenticatedSessionController
{
    //
    public function login()
    {
        return view('users.index');
    }
}
