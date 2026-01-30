<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EntityManager::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $db = $settings->get('db');

            $paths = [__DIR__ . '/../../src'];
            $isDevMode = true;

            $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

            $connection = [
                'driver' => ($db['driver'] === 'pgsql' ? 'pdo_pgsql' : $db['driver']),
                'host' => $db['host'],
                'port' => $db['port'],
                'dbname' => $db['database'],
                'user' => $db['username'],
                'password' => $db['password'],
                'charset' => $db['charset'] ?? 'utf8',
            ];

            return EntityManager::create($connection, $config);
        },
    ]);
};
