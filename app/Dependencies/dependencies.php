<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration as DBALConfiguration;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        \Doctrine\ORM\EntityManagerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $db = $settings->get('db');

            $paths = [__DIR__ . '/../../src'];
            $isDevMode = true;

            // Proxy directory for generated proxies
            $proxyDir = __DIR__ . '/../../var/cache/doctrine';
            if (!is_dir($proxyDir)) {
                @mkdir($proxyDir, 0777, true);
            }

            // Use the Attribute metadata driver (entities use PHP 8 attributes)
            $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode, $proxyDir, null);

            $dbalConfig = new DBALConfiguration();

            $params = [
                'driver' => (
                    ($db['driver'] === 'pgsql' || $db['driver'] === 'pdo_pgsql') ? 'pdo_pgsql' : (
                    ($db['driver'] === 'mysql' || $db['driver'] === 'pdo_mysql') ? 'pdo_mysql' : $db['driver']
                )),
                'host' => $db['host'],
                'port' => (int) $db['port'],
                'dbname' => $db['database'],
                'user' => $db['username'],
                'password' => $db['password'],
                'charset' => $db['charset'] ?? 'utf8',
            ];

            $connection = DriverManager::getConnection($params, $dbalConfig);

            return new EntityManager($connection, $config);
        },

        \Doctrine\ORM\EntityManager::class => function (ContainerInterface $c) {
            return $c->get(\Doctrine\ORM\EntityManagerInterface::class);
        },
    ]);
};