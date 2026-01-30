<?php

return [
    'paths' => [
        'migrations' => __DIR__ . '/database/migrations',
        'seeds' => __DIR__ . '/database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => getenv('DB_ADAPTER') ?: 'pgsql',
            'host' => getenv('DB_HOST') ?: '127.0.0.1',
            'name' => getenv('DB_DATABASE') ?: 'your_database',
            'user' => getenv('DB_USERNAME') ?: 'your_user',
            'pass' => getenv('DB_PASSWORD') ?: 'your_password',
            'port' => getenv('DB_PORT') ?: '5432',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
