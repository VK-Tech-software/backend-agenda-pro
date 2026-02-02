<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

class DatabaseException extends CustomException
{
    public function __construct(string $message = 'Database error', array $errors = [])
    {
        parent::__construct($message, 500, $errors);
    }
}
