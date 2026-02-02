<?php
declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Entities\UserEntity;
use App\Domain\User\Interfaces\UserInterface;
use App\Domain\User\Data\DTOs\Request\RegisterUserRequest;

final class RegisterUserService
{
    public function __construct(
        private UserInterface $users
    ) {}

    public function execute(RegisterUserRequest $request): void
    {
        $user = UserEntity::create(
            name: $request->name(),
            email: $request->email(),
            plainPassword: $request->password(),
            tipoConta: $request->tipoConta(),
            telefone: $request->telefone()
        );

        $this->users->save($user);
    }
}