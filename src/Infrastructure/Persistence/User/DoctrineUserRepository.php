<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\Entities\UserEntity;
use App\Domain\User\Interfaces\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineUserRepository implements UserInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function findByEmail(string $email): ?UserEntity
    {
        $orm = $this->em
            ->getRepository(UserOrm::class)
            ->findOneBy(['email' => $email]);

        if (!$orm) {
            return null;
        }

        return UserEntity::restore(
            id: $orm->getId(),
            name: $orm->getName(),
            email: $orm->getEmail(),
            passwordHash: $orm->getPassword(),
            tipoConta: 'PF',
            telefone: '',
            active: true,
            createdAt: $orm->getCreatedAt()
        );
    }

    public function save(UserEntity $user): void
    {
        $orm = new UserOrm(
            $user->name(),
            $user->email(),
            $user->passwordHash()
        );

        $this->em->persist($orm);
        $this->em->flush();
    }
}