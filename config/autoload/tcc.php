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
use Hyperf\Contract\StdoutLoggerInterface;
use Tcc\TccTransaction\Exception\Handle;

return [
    'nsq_detection_time' => 5, // NSQ检测补偿事务时间
    'nsq_topic' => env('APP_NAME', 'hyperf') . ':tcc', // NSQ Topic
    'redis_prefix' => env('APP_NAME', 'hyperf') . ':tcc', // Redis 缓存前缀
    'exception' => Handle::class, // 无法处理异常通知类
    'logger' => StdoutLoggerInterface::class, // 日志提供者
];
