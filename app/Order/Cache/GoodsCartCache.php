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

use Mine\Abstracts\AbstractRedis;
use RedisException;

class GoodsCartCache extends AbstractRedis
{
    protected ?string $prefix = 'yx_goods';

    protected string $typeName = 'cart';

    /**
     * @throws RedisException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function delCartData(int $productId, ?int $skuId): bool
    {
        $key = self::getKey('data');
        $key2 = $skuId ? $productId . '_' . $skuId : $productId;
        return $this->redis('goods')->hDel($key, (string) $key2);
    }
}
