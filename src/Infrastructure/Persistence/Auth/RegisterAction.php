<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\User\Services\RegisterUserService;
use App\Domain\User\Data\DTOs\Request\RegisterUserRequest;
use Psr\Http\Message\ResponseInterface as Response;

final class RegisterAction extends Action
{
    private RegisterUserService $service;

    public function __construct(RegisterUserService $service)
    {
        $this->service = $service;
    }

    protected function action(): Response
    {
        $data = (array) $this->getFormData();

        $registerRequest = RegisterUserRequest::fromArray($data);

        $this->service->execute($registerRequest);

        return $this->respondWithData(['message' => 'Usuário registrado com sucesso'], 201);
    }
}
