<?php
namespace App\Domain\User\Entities;
use DateTimeImmutable;

final class UserEntity
{


    private function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private string $passwordHash,
        private string $tipoConta,
        private string $telefone,
        private bool $active,
        private DateTimeImmutable $createdAt
    ) {
        $this->changeName(name: $name);
    }


    public static function create(
        string $name,
        string $email,
        string $plainPassword,
        string $tipoConta,
        string $telefone
    ): self {

        return new self(
            id: null,
            name: $name,
            email: $email,
            passwordHash: password_hash($plainPassword, PASSWORD_DEFAULT),
            tipoConta: $tipoConta,
            telefone: $telefone,
            active: true,
            createdAt: new \DateTimeImmutable()
        );
    }

    public static function restore(
        int $id,
        string $name,
        string $email,
        string $passwordHash,
        string $tipoConta,
        string $telefone,
        bool $active,
        DateTimeImmutable $createdAt
    ): self {
        return new self(
            $id,
            $name,
            $email,
            $passwordHash,
            $tipoConta,
            $telefone,
            $active,
            $createdAt
        );
    }

    public function changeName(string $name): void
    {
        if (strlen(trim($name)) < 3) {
            throw new \InvalidArgumentException('Nome inválido.');
        }
        $this->name = $name;
    }

    public function deactivate(): void
    {
        $this->active = false;
    }

    public function activate(): void
    {
        $this->active = true;
    }

    public function id(): ?int { return $this->id; }
    public function name(): string { return $this->name; }
    public function email(): string { return $this->email; }
    public function passwordHash(): string { return $this->passwordHash; }
    public function tipoConta(): string { return $this->tipoConta; }
    public function telefone(): string { return $this->telefone; }
    public function isActive(): bool { return $this->active; }
    public function createdAt(): DateTimeImmutable { return $this->createdAt; }
}
