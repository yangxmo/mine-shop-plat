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
namespace App\System\Listener;

use App\System\Cache\UserCache;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Mine\Event\UserDelete;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RedisException;

/**
 * Class UserDeleteListener.
 */
#[Listener]
class UserDeleteListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            UserDelete::class,
        ];
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedisException
     */
    public function process(object $event): void
    {
        /** @var UserCache $redis */
        $redis = make(UserCache::class);
        $user = user();

        /* @var $event UserDelete */
        foreach ($event->ids as $uid) {
            $token = $redis->getUserTokenCache($uid);
            $token && $user->getJwt()->logout($token);
            $redis->delUserTokenCache($uid);
        }
    }
}
