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
namespace App\Order\Cache;

use Hyperf\Codec\Json;
use Mine\Abstracts\AbstractRedis;
use Redis;
use RedisException;

class OrderCache extends AbstractRedis
{
    protected ?string $prefix = 'yx_order';

    protected string $typeName = 'data';

    /**
     * 设置确认订单页面缓存.
     * @throws RedisException
     */
    public function setConfirmCache(string $orderNo, array $params, int $ttl = 180): void
    {
        $key = self::getKey('confirm:' . $orderNo);

        $this->redis('order')->set($key, Json::encode($params), $ttl);
    }

    /**
     * 获取确认订单页数据.
     * @throws RedisException
     */
    public function getConfirmCache(int $orderNo): array
    {
        $key = self::getKey('confirm:' . $orderNo);

        $result = $this->redis('order')->get($key);

        if ($result) {
            return Json::decode($result);
        }
        return [];
    }

    /**
     * @return false|int|Redis
     * @throws RedisException
     */
    public function delConfirmCache(string $orderNo): bool|int|Redis
    {
        $key = self::getKey('confirm:' . $orderNo);
        return $this->redis('order')->del($key);
    }

    /**
     * 创建订单成功后待支付的订单缓存.
     * @throws RedisException
     */
    public function setNoPaidOrderCache(string $orderNo, array $params, int $ttl = 1000): void
    {
        $key = self::getKey('no_paid:' . $orderNo);

        $this->redis('order')->set($key, Json::encode($params), $ttl);
    }

    /**
     * @throws RedisException
     */
    public function getNoPaidOrderCache(string $orderNo): array
    {
        $key = self::getKey('no_paid:' . $orderNo);

        $result = $this->redis('order')->get($key);

        if ($result) {
            return Json::decode($result);
        }

        return [];
    }

    /**
     * @throws RedisException
     */
    public function delNoPaidOrderCache(string $orderNo): void
    {
        $key = self::getKey('no_paid:' . $orderNo);

        $this->redis('order')->del($key);
    }
}
