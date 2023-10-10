<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(
            function (Throwable $e, $request) {
                if ($request->is('api/*')) {
                    $this->apiErrorResponse($request, $e);
                }
            }
        );

        $this->reportable(
            function (Throwable $e) {
                //
            }
        );
    }

    private function apiErrorResponse($request, $e)
    {
        // APIルーティング
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            switch ($statusCode) {
            case 400:
                $message = __('messages.exception.400');
                break;
            case 403:
                $message = __('messages.exception.403');
                break;
            case 404:
                $message = __('messages.exception.404');
                break;
            case 405:
                $message = __('messages.exception.405');
                break;
            case 500:
                $message = __('messages.exception.500');
                break;
            default:
                return;
            }

            return response()->error($statusCode, $message);
            // return response()->json(
            //     [
            //         'status' => $statusCode,
            //         'message' => $message,
            //         'content' => []
            //     ], $statusCode
            // );
        }

        // HttpException 以外の場合
        return response()->json(
            [
            'status' => 500,
            'message' => __('messages.exception.500'),
            ], 500, [
            'Content-Type' => 'application/problem+json',
            ]
        );
    }
}
