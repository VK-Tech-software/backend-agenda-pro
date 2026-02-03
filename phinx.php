<?php

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/src/Infrastructure/Database/Migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/src/Infrastructure/Database/Seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => getenv('DB_DRIVER') ?: 'mysql',
            'host' => getenv('DB_HOST') ?: '127.0.0.1',
            'name' => getenv('DB_NAME') ?: 'agendapro',
            'user' => getenv('DB_USER') ?: 'root',
            'pass' => getenv('DB_PASSWORD') ?: 'root',
            'port' => getenv('DB_PORT') ?: '8889',
            'charset' => 'utf8',
        ]

    ],
    'version_order' => 'creation'
];
