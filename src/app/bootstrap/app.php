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
        $middleware->redirectGuestsTo(fn () => route('login.index'));
        $middleware->alias([
            'custom_guest' => \App\Http\Middleware\CustomRedirectIfAuthenticated::class
        ]);
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

            // バリデーションエラー時はLaravelのロジックで処理する
            // 403,404,405,500エラーはInertiaのエラーページを表示
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return null;
            }

            // 認証エラー時はLaravelのロジックで処理する
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return null;
            }

            $status = 500;

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                $status = $e->getStatusCode();
            }

            $errorPage = match ($status) {
                403 => 'Errors/403',
                404 => 'Errors/404',
                405 => 'Errors/405',
                500 => 'Errors/500',
                default => 'Errors/500',
            };

            return inertia($errorPage)->toResponse($request)->setStatusCode($status);
        });
    })->create();
