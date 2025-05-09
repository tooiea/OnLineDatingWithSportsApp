<?php
declare(strict_types=1);
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
        $user = $request->user();

        // 常に共通で渡す情報
        Inertia::share([
            'auth_routes' => $user ? [
                'current' => url()->current(),
                'home' => route('home'),
                'team_list' => route('team.list'),
                'myteam_index' => route('myteam.index'),
                'myteam_detail' => route('myteam.detail'),
                'my_profile' => route('my-profile.detail'),
                'logout' => route('logout'),
            ] : null,
            'guest_routes' => !$user ? [
                'login' => route('login.index'),
                'password_email' => route('password.email'),
                'password_reset' => route('password.store'),
            ] : null,
        ]);

        // 認証済みユーザ情報がある場合のみ追加
        if ($user) {
            $user->loadMissing('teamMember.team');

            Inertia::share([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'image_path' => $user->image?->path_base64,
                    'team' => $user->teamMember?->team ? [
                        'name' => $user->teamMember->team->name,
                    ] : null,
                ],
            ]);
        }

        return $next($request);
    }
}
