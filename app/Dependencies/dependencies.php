<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration as DBALConfiguration;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        LoggerInterface::class => fn() => new NullLogger(),

        \Doctrine\ORM\EntityManagerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $db = $settings->get('db');

            $paths = [__DIR__ . '/../../src'];
            $isDevMode = true;

            $proxyDir = __DIR__ . '/../../var/cache/doctrine';
            if (!is_dir($proxyDir))
                @mkdir($proxyDir, 0777, true);

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

        \App\Domain\Shared\Interfaces\MailerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $mail = $settings->get('mail') ?? [];

            $from = !empty($mail['from']) ? (string) $mail['from'] : 'no-reply@example.com';
            $smtpHost = !empty($mail['smtp_host']) ? (string) $mail['smtp_host'] : null;
            $port = !empty($mail['smtp_port']) ? (int) $mail['smtp_port'] : 587;
            $user = !empty($mail['smtp_user']) ? (string) $mail['smtp_user'] : null;
            $pass = !empty($mail['smtp_password']) ? (string) $mail['smtp_password'] : null;

            return new \App\Infrastructure\Mail\PHPMailerMailer($smtpHost, $port, $user, $pass, $from);
        },

        \App\Infrastructure\Listeners\SendEmailListener::class => function (ContainerInterface $c) {
            return new \App\Infrastructure\Listeners\SendEmailListener(
                $c->get(\App\Domain\Shared\Interfaces\MailerInterface::class)
            );
        },

        \App\Infrastructure\Events\EventDispatcher::class => function (ContainerInterface $c) {
            $dispatcher = new \App\Infrastructure\Events\EventDispatcher();

            $emailListener = $c->get(\App\Infrastructure\Listeners\SendEmailListener::class);
            $dispatcher->listen(
                \App\Domain\Shared\Events\EmailEventInterface::class,
                fn($event) => $emailListener->handle($event)
            );

            return $dispatcher;
        },
    ]);
};