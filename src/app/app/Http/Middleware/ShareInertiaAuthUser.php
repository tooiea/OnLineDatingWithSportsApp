<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareInertiaAuthUser
{
    /**
     * 認証されたユーザの場合
     * 共通レイアウトで利用するユーザ情報を渡す
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $user = $request->user()->loadMissing('teamMember.team');

            Inertia::share('auth.user', [
                'name' => $user->name,
                'email' => $user->email,
                'image_path' => $user->image?->path_base64,
                'team' => $user->teamMember?->team ? [
                    'name' => $user->teamMember->team->name,
                ] : null,
            ]);
        }

        return $next($request);
    }
}
