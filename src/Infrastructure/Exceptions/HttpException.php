<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class HttpException extends CustomException
{
    public function __construct(string $message, int $statusCode = 400, array $errors = [])
    {
        parent::__construct($message, $statusCode, $errors);
    }
}
