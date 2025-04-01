<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CustomRedirectIfAuthenticated extends RedirectIfAuthenticated
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Closure $next
     * @param string ...$guards
     * @return Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // guardに応じてリダイレクト先を分ける
                return match ($guard) {
                    'user' => redirect()->route('myteam.index'),
                    'admin' => redirect('/admin/dashboard'), // 管理者用のリダイレクト先(未定)
                    default => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}
