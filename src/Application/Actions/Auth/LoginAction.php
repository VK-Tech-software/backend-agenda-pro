<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\User\UserEntity;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class LoginAction extends Action
{
    private EntityManager $em;

    public function __construct(LoggerInterface $logger, EntityManager $em)
    {
        parent::__construct($logger);
        $this->em = $em;
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        if (empty($data['email']) || empty($data['password'])) {
            return $this->respondWithData(['error' => 'Missing credentials'], 400);
        }

        $email = strtolower($data['email']);

        $repo = $this->em->getRepository(UserEntity::class);
        $user = $repo->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->respondWithData(['error' => 'Invalid credentials'], 401);
        }

        if (!password_verify($data['password'], $user->getPassword())) {
            return $this->respondWithData(['error' => 'Invalid credentials'], 401);
        }

        $this->logger->info('User logged in: ' . $email);

        return $this->respondWithData([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ]);
    }
}
