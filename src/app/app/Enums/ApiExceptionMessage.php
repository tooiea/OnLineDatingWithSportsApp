<?php

namespace App\Enums;

enum ApiExceptionMessage : int
{
    case INVALID_CREDENTIALS = 400;
    case UNAUTHORIZED = 401;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case VALIDATION_ERROR = 422;
    case INTERNAL_SERVER_ERROR = 500;

    public function getMessage(): string
    {
        return match ($this) {
            self::INVALID_CREDENTIALS => 'Invalid Credentials',
            self::UNAUTHORIZED => 'Unauthorized',
            self::NOT_FOUND => 'Not Found',
            self::METHOD_NOT_ALLOWED => 'Method Not Allowed',
            self::VALIDATION_ERROR => 'Validation Error',
            self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        };
    }
}
