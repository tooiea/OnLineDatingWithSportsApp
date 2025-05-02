<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
            Inertia::share([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'image_path' => $user->image?->path_base64,
                    'team' => $user->teamMember?->team ? [
                        'name' => $user->teamMember->team->name,
                    ] : null,
                ],
                'nav_routes' => [
                    'current' => url()->current(),
                    'home' => '',
                    'team_list' => route('team.list'),
                    'myteam_index' => route('myteam.index'),
                    'myteam_detail' => route('myteam.detail'),
                    'my_profile' => route('my-profile.detail'),
                    'logout' => route('logout'),
                ],

            ]);
        } else {
            Inertia::share([
                'layout_routes'=> [
                    'password_email' => route('password.email'),
                    'password_reset' => route('password.store'),
                ],
            ]);
        }

        return $next($request);
    }
}
