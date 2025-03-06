<?php

use App\Enums\ApiExceptionMessage;
use App\Http\Middleware\CustomSetCacheHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->replace(SetCacheHeaders::class, CustomSetCacheHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                $message = '';
                switch ($e) {
                    case $e instanceof RequestException:
                        $status = $e->response->status();
                        break;
                    case $e instanceof UnauthorizedException:
                        $status = Response::HTTP_UNAUTHORIZED;
                        break;
                    case $e instanceof NotFoundHttpException:
                        $status = $e->getStatusCode();
                        break; 
                    case $e instanceof MethodNotAllowedHttpException:
                        $status = $e->getStatusCode();
                        break;
                    case $e instanceof ValidationException:
                        $status = $e->status;
                        $message = $e->validator->errors()->toArray();
                        break;
                    default:
                        Log::error($e->getTraceAsString());
                        $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                        break;
                }
                return response()->apiError(
                    message: $message ? $message : ApiExceptionMessage::from($status)->getMessage(),
                    status: $status
                );
            }
        });
    })->create();
