<?php

namespace App\Http\Middleware;

use App\Models\TeamMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotJoinTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインユーザ取得し、所属チームが存在するかをチェックする
        $team = TeamMember::getTeamByUserId(Auth::id());

        // ログイン済みかつチームに所属している場合、チームトップページへ遷移する
        if (!empty($team)) {
            return redirect()->route('team.index');
        }

        return $next($request);
    }
}
