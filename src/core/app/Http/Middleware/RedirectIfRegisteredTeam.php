<?php

namespace App\Http\Middleware;

use App\Models\TeamMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfRegisteredTeam
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

        // ログイン済みでチームに所属していない場合、チーム登録かチームへ参加するトップ画面へ遷移する
        if (empty($team)) {
            return redirect()->route('tmp_sns_top.index');
        }

        return $next($request);
    }
}
