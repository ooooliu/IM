<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'default' => [
        'driver' => env('DB_DRIVER', 'mysql'),
        'host' => env('DB_HOST', '172.17.0.2'),
        'database' => env('DB_DATABASE', 'im'),
        'port' => env('DB_PORT', 3306),
        'username' => env('DB_USERNAME', 'lyn'),
        'password' => env('DB_PASSWORD', 'asdasd'),
        'charset' => env('DB_CHARSET', 'utf8'),
        'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 60),
        ],
        'commands' => [
            'gen:model' => [
                'path' => 'app/Model',
                'force_casts' => true,
                'inheritance' => 'Model',
            ],
        ],
    ],
    'mongodb' => [
        'driver'   => 'mongodb',
        'host'     => env('MONGODB_HOST', '172.17.0.7'),
        'port'     => env('MONGODB_PORT', 27017),
        'database' => env('MONGODB_DATABASE', 'im'),
        'username' => env('MONGODB_USERNAME', ''),
        'password' => env('MONGODB_PASSWORD', ''),
        'options'  => [
            'database' => env('MONGODB_AUTH_DATABASE', 'admin'),
        ],
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('MONGODB_MAX_IDLE_TIME', 60),
        ],
    ],
];
