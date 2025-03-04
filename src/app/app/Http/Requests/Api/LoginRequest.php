<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends AuthLoginRequest
{
    protected $guard = 'user';
}
