<?php
namespace App\Domain\User\Data\DTOs\Request;

use App\Infrastructure\Exceptions\ValidationException;

final class LoginUserRequest
{
    public function __construct(
        private string $email,
        private string $password
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        $errors = [];

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido.';
        }

        if (strlen($this->password) < 4) {
            $errors['password'] = 'Senha deve ter no mínimo 4 caracteres.';
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
