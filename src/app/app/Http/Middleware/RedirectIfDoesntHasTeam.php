<?php
declare(strict_types=1);
namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfDoesntHasTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::whereRelation('teamMember', 'user_id', Auth::id())->find(Auth::id());

        // ログイン時にユーザに紐づくチームの情報がない場合
        if (empty($user)) {
            return redirect()->route('register.team.select');
        }

        return $next($request);
    }
}
