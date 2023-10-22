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
use Mine\Annotation\DependProxyCollector;

return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
        ],
        // 初始化注解收集器
        'collectors' => [
            DependProxyCollector::class,
        ],
        'ignore_annotations' => [
            'mixin',
            'required',
        ],
    ],
];
