<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Infrastructure\Persistence\User\UserEntity;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class RegisterAction extends Action
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

        $required = ['email', 'password', 'username', 'firstName', 'lastName'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->respondWithData(['error' => "Missing field {$field}"], 400);
            }
        }

        $email = strtolower($data['email']);

        $repo = $this->em->getRepository(UserEntity::class);
        $existing = $repo->findOneBy(['email' => $email]);
        if ($existing) {
            return $this->respondWithData(['error' => 'Email already registered'], 400);
        }

        $user = new UserEntity();
        $user->setEmail($email);
        $user->setUsername($data['username']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        $this->em->persist($user);
        $this->em->flush();

        $this->logger->info('New user registered: ' . $email);

        return $this->respondWithData([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ], 201);
    }
}
