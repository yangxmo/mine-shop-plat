<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
$tenantIds = require __DIR__ . '/tenant.php';

$databaseTemple = [
    'driver' => env('DB_DRIVER', 'mysql'),
    'host' => env('DB_HOST', 'localhost'),
    'database' => env('DB_DATABASE', 'mine_shop'),
    'port' => env('DB_PORT', 3306),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', 'root'),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
    'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
    'prefix' => env('DB_PREFIX', ''),
    'pool' => [
        'min_connections' => 1,
        'max_connections' => 20,
        'connect_timeout' => 10.0,
        'wait_timeout' => 3.0,
        'heartbeat' => -1,
        'max_idle_time' => (float) env('DB_MAX_IDLE_TIME', 60),
    ],
    'cache' => [
        'handler' => \Hyperf\ModelCache\Handler\RedisHandler::class,
        'cache_key' => 'MineAdmin:%s:m:%s:%s:%s',
        'prefix' => 'model-cache',
        'ttl' => 86400 * 7,
        'empty_model_ttl' => 60,
        'load_script' => true,
        'use_default_value' => false,
    ],
    'commands' => [
        'gen:model' => [
            'path' => 'app/Model',
            'force_casts' => true,
            'inheritance' => 'MineModel',
            'uses' => 'Mine\MineModel',
            'with_comments' => true,
            'refresh_fillable' => true,
            'visitors' => [
                Hyperf\Database\Commands\Ast\ModelRewriteKeyInfoVisitor::class,
                Hyperf\Database\Commands\Ast\ModelRewriteTimestampsVisitor::class,
                Hyperf\Database\Commands\Ast\ModelRewriteSoftDeletesVisitor::class,
                Hyperf\Database\Commands\Ast\ModelRewriteGetterSetterVisitor::class,
            ],
        ],
    ],
];

return \Hyperf\Support\value(function () use ($databaseTemple, $tenantIds) {
    $database = [];
    array_map(function ($tenant) use (&$database, $databaseTemple) {
        if (\Hyperf\Support\env('APP_ENV') !== 'local') {
            $tenant != 'default' && $databaseTemple['username'] .= '_' . $tenant;
        }
        $tenant != 'default' && $databaseTemple['database'] .= '_' . $tenant;
        $database[$tenant] = $databaseTemple;
    }, $tenantIds['tenant']);
    return $database;
});
