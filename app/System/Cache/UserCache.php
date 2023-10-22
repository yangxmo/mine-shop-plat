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
namespace App\System\Cache;

use Hyperf\Config\Annotation\Value;
use Mine\Abstracts\AbstractRedis;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

class UserCache extends AbstractRedis
{
    #[value('redis.user.prefix')]
    protected ?string $prefix;

    protected string $typeName = 'user';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function setUserTokenCache(int $uid, string $token, int $ttl = -1): void
    {
        $key = $this->getKey('Token:' . $uid);
        $this->redis('user')->set($key, $token, $ttl);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function getUserTokenCache(int $uid): ?string
    {
        $key = $this->getKey('Token:' . $uid);
        return $this->redis('user')->get($key);
    }

    /**
     * @param mixed $iterator
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scanOnlineUser(&$iterator, int $limit = 100): mixed
    {
        $key = $this->getKey('Token:*');
        return $this->redis('user')->scan($iterator, $key, $limit);
    }

    public function getScanOnlineUserKey(): string
    {
        return $this->getKey('Token:*');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function delUserTokenCache(int $uid): void
    {
        $key = $this->getKey('Token:' . $uid);
        $this->redis('user')->del($key);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function delUserCache(int $uid): void
    {
        $key = $this->getKey('userInfo_' . $uid);
        $this->redis('user')->del($key);
    }
}
