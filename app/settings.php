<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                    'db' => [
                        'driver' => getenv('DB_DRIVER') ?: 'pdo_mysql',
                        'host' => getenv('DB_HOST') ?: '127.0.0.1',
                        'database' => getenv('DB_NAME') ?: 'agendapro',
                        'username' => getenv('DB_USER') ?: 'root',
                        'password' => getenv('DB_PASSWORD') ?: 'root',
                        'port' => getenv('DB_PORT') ?: '8889',
                    'charset' => 'utf8',
                    'prefix' => '',
                ],
            ]);
        }
    ]);
};
