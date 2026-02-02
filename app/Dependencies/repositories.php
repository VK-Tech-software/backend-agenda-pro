<?php

declare(strict_types=1);

use App\Domain\User\Interfaces\UserInterface;
use App\Infrastructure\Persistence\User\DoctrineUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Map the domain UserInterface to the Doctrine implementation
    $containerBuilder->addDefinitions([
        UserInterface::class => \DI\autowire(DoctrineUserRepository::class),
    ]);
};
