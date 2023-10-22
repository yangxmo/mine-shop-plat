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

use Hyperf\Config\Annotation\Value;
use Lysice\HyperfRedisLock\RedisLock;
use Mine\Abstracts\AbstractRedis;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

class GoodsStockLuaCache extends AbstractRedis
{
    #[value('redis.goods.prefix')]
    protected ?string $prefix = 'yx_goods';

    protected string $typeName = 'stock';

    # 获取库存 key
    public function getStockKey(int $key1, ?int $key2 = null, ?string $typeName = null): string
    {
        $this->typeName = $typeName ?: $this->typeName;

        if ($key2) {
            return $this->getKey("{$key1}_{$key2}");
        }
        return $this->getKey("{$key1}");
    }

    /**
     * 检测锁定的库存是否大于剩余的库存.
     * @param string $key1 spuKey
     * @param string $key2 skuKey
     * @param int $num 购买数量
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function checkLockStock(string $key1, string $key2, int $num): int
    {
        $script = <<<'LUA'
            local key = KEYS[1]
            local key2 = KEYS[2]
            local value = ARGV[1]

            --当前库存
            local now_stock = tonumber(redis.call('get', key1))
            --锁定的库存
            local lock_stock = tonumber(redis.call('get', key2))
            --购买数量
            value = tonumber(value)
            
            --锁定的库存+购买库存 大于 所剩余的库存 = 库存不足
            if (lock_stock != nil and (lock_stock + value) > now_stock) then
                return 0
            end
            --无锁定库存，但是购买数量超过剩余库存 = 库存不足
            if (lock_stock == nil and value > now_stock) then
                return 0
            end
            
            return 1
LUA;
        return $this->execLuaScript($script, [$key1, $key2, $num], 2);
    }

    /**
     * 检查库存.
     * @param array $goodsData 商品数据
     * @return int 返回（0/1）
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function checkStock(array $goodsData): int
    {
        $luaData = $this->getLuaData($goodsData);

        $script = <<<LUA
            local goods = {$luaData}
            
            --开始增加锁定的库存
            for key,value in pairs(goods) do        
                --商品当前锁定的库存
                local now_stock = tonumber(redis.call('get', key))
                --商品库存(剩余的库存是否足够扣除)
                if (now_stock == nil or now_stock < value) then
                    return 0
                end
            end
            
            return 1
LUA;

        return $this->execLuaScript($script, [], 0);
    }

    /**
     * 锁定库存.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function addLockStock(array $productData): int
    {
        // 设定库存锁的key
        $this->typeName = 'stock_lock';

        $luaData = $this->getLuaData($productData);

        $script = <<<LUA
            local goods = {$luaData}
            
            --开始增加锁定的库存
            for key,value in pairs(goods) do        
                --商品当前锁定的库存
                local now_stock = tonumber(redis.call('get', key))
                --商品锁定库存处理(剩余的库存加需购买的库存数)
                if (now_stock != nil) then
                    local lock_stock = tonumber(now_stock) + tonumber(value)
                    --将剩余的库存写入key中
                    redis.call('set', key, lock_stock)
                else
                    --将剩余的库存写入key中
                    redis.call('set', key, tonumber(value))
                end
                
            end
            
            return 1
LUA;

        return $this->execLuaScript($script, [], 0);
    }

    /**
     * 库存扣减，解锁锁定的库存.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function reduceStock(array $productData): int
    {
        // 真实商品库存数据
        $luaData = $this->getLuaData($productData);

        // 锁定商品库的数据
        // 设置库存锁的key
        $this->typeName = 'stock_lock';
        $luaLockData = $this->getLuaData($productData);

        $script = <<<LUA
            local goods = {$luaData}
            local lock_goods = {$luaLockData}

            --减少锁定的库存
            for lock_key,value in pairs(lock_goods) do
                local lock_stock = tonumber(redis.call('get', lock_key))
                --商品库存减少处理(剩余的库存减去购买的库存)
                local reduce_lock_stock = tonumber(lock_stock) - tonumber(value)
                --开始减少锁定的库存
                if (tonumber(value) == reduce_lock_stock) then
                    redis.call('set', lock_key, 0)
                else
                    redis.call('set', lock_key, reduce_stock)
                end
            end

            --开始减少真实的库存
            for key,value in pairs(goods) do        
                --商品剩余库存
                local now_stock = tonumber(redis.call('get', key))
                --商品库存减少处理(剩余的库存减去购买的库存)
                local reduce_stock = tonumber(now_stock) - tonumber(value)
                --将剩余的库存写入key中
                if (tonumber(value) == now_stock) then
                    redis.call('del', key)
                else
                    redis.call('set', key, reduce_stock)
                end
            end
            
            return 1
LUA;

        return $this->execLuaScript($script, [], 0);
    }

    /**
     * 库存还原.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function addStock(array $productData): int
    {
        // 真实商品库存数据
        $luaData = $this->getLuaData($productData);

        $script = <<<LUA
            local goods = {$luaData}

            --开始还原库存
            for key,value in pairs(goods) do        
                --商品剩余库存
                local now_stock = tonumber(redis.call('get', key))
                --商品库存增加处理(剩余的库存+购买的库存)
                local reduce_stock = tonumber(now_stock) + tonumber(value)
                --将剩余的库存写入key中
                if (tonumber(value) == now_stock) then
                    redis.call('del', key)
                else
                    redis.call('set', key, reduce_stock)
                end
            end
            
            return 1
LUA;

        return $this->execLuaScript($script, [], 0);
    }

    /**
     * 退回锁定的库存.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function releaseStock(array $productData): void
    {
        // 设置库存锁的key
        $this->typeName = 'stock_lock';

        $luaData = $this->getLuaData($productData);

        $script = <<<LUA
            local goods = {$luaData}
            
            --开始增加库存
            for key,value in pairs(goods) do        
                --商品剩余库存
                local now_stock = tonumber(redis.call('get', key))
                
                --如果库存没key了
                if (now_stock == nil) then
                    redis.call('set', key, 0)
                    return 1
                end
                
                --商品库存增加处理(锁定的库存 - 购买的库存)
                local add_stock = tonumber(now_stock) - tonumber(value)
                --将剩余的库存写入key中
                return redis.call('set', key, add_stock)
            end
            
            return 1
LUA;

        $this->execLuaScript($script, [], 0);
    }

    /**
     * 锁执行.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function lock(callable $fun, string $key, int $timeOut = 5): mixed
    {
        $lock = make(RedisLock::class, [$this->redis('goods'), $key, $timeOut]);

        return $lock->get(function () use ($fun) {
            return call_user_func($fun);
        });
    }

    # 组装lua 数组对象脚本
    private function getLuaData(array $productData): string
    {
        $luaData = '{';
        array_map(function ($value) use (&$luaData) {
            if ($value['goods_sku_id']) {
                $key = $this->getKey("{$value['id']}_{$value['goods_sku_id']}");
            } else {
                $key = $this->getKey("{$value['id']}");
            }
            $luaData .= "['{$key}']={$value['goods_num']}";
        }, $productData);

        $luaData .= '}';
        return $luaData;
    }

    /**
     * 执行lua脚本.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    private function execLuaScript(string $script, array $params, int $keyNum = 1): mixed
    {
        $hash = $this->redis('goods')->script('load', $script);

        return $this->redis('goods')->evalSha($hash, $params, $keyNum);
    }
}
