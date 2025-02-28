<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends AuthLoginRequest
{
    protected $guard = 'user';
}
