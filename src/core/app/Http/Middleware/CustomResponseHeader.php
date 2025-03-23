<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * セキュリティ周りのヘッダー設定
 */
class CustomResponseHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // クリックジャッキング対策(現状は、iframe/frameは使用していないため全て)
        $response->header('X-FRAME-OPTIONS', 'DENY');

        // CSP設定
        // css,img,jsのドメインは現状使用している読み込み先を限定した形で設定(他に追加が必要であれば追加する)
        $csp = <<<'END'
        default-src 'self';
        style-src 'self' 'unsafe-inline' cdn.jsdelivr.net cdnjs.cloudflare.com;
        img-src 'self' data:;
        script-src 'self' 'unsafe-inline' ajax.googleapis.com cdnjs.cloudflare.com maxcdn.bootstrapcdn.com;
        END;

        $csp = preg_replace('~(\s)+~u', ' ', trim($csp)); // スペースを整理して1行に
        $response->headers->set('Content-Security-Policy', $csp);

        // X-Content-Type-Options
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
