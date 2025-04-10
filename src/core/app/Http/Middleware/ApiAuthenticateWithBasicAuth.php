<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticateWithBasicAuth
{
    private const USER_NAME = 'oldws_api';
    private const PASSWORD = '$2y$10$/fVkUfsPnvb0tJQpTlxJzudK8WSFa7ofMQxWJCvqkvrivWFBp.B3e';
    // kURJ1hp2Hv
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userName = $request->getUser();
        $password = $request->getPassword();


        if ($userName === self::USER_NAME && Hash::check($password, self::PASSWORD)) {
            return $next($request);
        }

        abort(401, "Enter username and password.", [
            header('WWW-Authenticate: Basic realm="Sample Private Page"'),
            header('Content-Type: application/json; charset=utf-8')
        ]);
    }
}
