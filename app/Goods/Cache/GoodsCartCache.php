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

namespace App\Goods\Cache;

use Hyperf\Codec\Json;
use Hyperf\Config\Annotation\Value;
use Mine\Abstracts\AbstractRedis;

class GoodsCartCache extends AbstractRedis
{
    #[value('redis.goods.prefix')]
    protected ?string $prefix;

    protected string $typeName = 'cart';

    /**
     * 获取列表.
     */
    public function getCart(): array
    {
        $key = $this->getKey('userId:' . clientUserId());

        $result = $this->redis('goods')->hGetAll($key);

        return $result ?? [];
    }

    /**
     * 获取指定产品列表.
     */
    public function getCartData(int $goodsId, ?string $skuId): array
    {
        $key = $this->getKey('userId:' . clientUserId());
        $key2 = $skuId ? $goodsId . '_' . $skuId : $goodsId;

        $result = $this->redis('goods')->hGet($key, $key2);

        return $result ? Json::decode($result) : [];
    }

    /**
     * 删除一个数量.
     */
    public function reduceCart(int $goodsId, ?string $skuId, int $num = 1): bool
    {
        $key = $this->getKey('userId:' . clientUserId());

        $key2 = $skuId ? $goodsId . '_' . $skuId : $goodsId;

        $num = $this->redis('goods')->hIncrBy($key, (string) $key2, -$num);

        if ($num <= 0) {
            $this->redis('goods')->hDel($key, $key2);
            return $this->delCartData($goodsId, $skuId);
        }

        return true;
    }

    /**
     * 设置购物车.
     */
    public function setCartData(int $goodsId, ?string $skuId, array $data): bool
    {
        $key = $this->getKey('userId:' . clientUserId());
        $key2 = $skuId ? $goodsId . '_' . $skuId : $goodsId;
        return (bool) $this->redis('goods')->hSet($key, (string) $key2, Json::encode($data));
    }

    /**
     * 减少购物车数量.
     */
    public function delCartData(int $goodsId, ?string $skuId): bool
    {
        $key = $this->getKey('userId:' . clientUserId());
        $key2 = $skuId ? $goodsId . '_' . $skuId : $goodsId;
        return $this->redis('goods')->hDel($key, (string) $key2);
    }

    /**
     * 清空.
     */
    public function clearCart(): bool
    {
        $key = $this->getKey('userId:' . clientUserId());

        return $this->redis('goods')->del($key);
    }
}
