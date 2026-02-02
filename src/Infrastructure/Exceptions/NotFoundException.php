<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class NotFoundException extends CustomException
{
    public function __construct(string $message = 'Resource not found', array $errors = [])
    {
        parent::__construct($message, 404, $errors);
    }
}
