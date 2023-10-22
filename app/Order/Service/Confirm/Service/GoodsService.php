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
namespace App\Order\Service\Confirm\Service;

use App\Goods\Mapper\GoodsMapper;
use App\Goods\Mapper\GoodsSkuMapper;
use App\Order\Cache\GoodsStockLuaCache;
use App\Order\Vo\OrderServiceVo;
use Hyperf\Collection\Arr;
use Hyperf\Database\Query\Expression;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Mine\Exception\MineException;

class GoodsService
{
    #[Inject]
    protected GoodsMapper $goodsMapper;

    #[Inject]
    protected GoodsSkuMapper $goodsSkuMapper;

    #[Inject]
    protected GoodsStockLuaCache $goodsStockLuaCache;

    # 获取商品详情
    public function getGoods(OrderServiceVo $vo): array
    {
        return $vo->productData;
    }

    # 锁定库存
    public function lockStock(OrderServiceVo $vo): void
    {
        $this->goodsStockLuaCache->lock(function () use ($vo) {
            // 检查库存 （检查锁定的库存是否大于当前可使用的库存数量）
            Arr::where($vo->productData, function ($goods) {
                // 检查库存
                $nowStockKey = $this->goodsStockLuaCache->getStockKey((int) $goods['id'], (int) $goods['goods_sku_id'] ?? null);
                $lockStockKey = $this->goodsStockLuaCache->getStockKey((int) $goods['id'], (int) $goods['goods_sku_id'] ?? null, 'stock_lock');
                // 检查锁定库存是否可以成功
                $checkStock = $this->goodsStockLuaCache->checkLockStock($nowStockKey, $lockStockKey, (int) $goods['goods_num']);
                // 库存不足
                if (! $checkStock) {
                    throw new MineException('商品：' . $goods['goods_name'] . $goods['goods_sku_name'] . '库存不足');
                }
            });

            // 锁定库存
            if ($this->goodsStockLuaCache->addLockStock($vo->getProductData()) !== 1) {
                throw new MineException('商品扣除库存失败');
            }
        }, 'goods_stock_lock');
    }

    # 解锁库存
    public function releaseStock(OrderServiceVo $vo): void
    {
        // 还原锁定的库存
        if ($this->goodsStockLuaCache->releaseStock($vo->getProductData()) !== 1) {
            throw new MineException('还原商品库存失败');
        }
    }

    # 扣减库存
    public function subStock(OrderServiceVo $vo): void
    {
        // 锁定的库存进行解锁，真实商品redis库存扣减，数据库扣减
        $this->goodsStockLuaCache->lock(function () use ($vo) {
            // 减少真实库存，解锁锁定的库存
            if ($this->goodsStockLuaCache->reduceStock($vo->getProductData()) !== 1) {
                throw new MineException('商品扣除库存失败');
            }
            // 数据库商品库存减少
            Db::transaction(function () use ($vo) {
                Arr::where($vo->getProductData(), function ($goods) {
                    // 处理单产品
                    if (empty($goods['goods_sku_id'])) {
                        $reduceStockStatus = $this->goodsMapper->getModel()
                            ->where('id', $goods['id'])
                            ->whereRaw(Db::raw('`goods_sale` > 0'))
                            ->lockForUpdate()
                            ->update([
                                'goods_sale' => new Expression('`goods_sale` - ' . $goods['goods_num']),
                            ]);
                    } else {
                        $reduceStockStatus = $this->goodsSkuMapper->getModel()
                            ->where('goods_sku_id', $goods['goods_sku_id'])
                            ->whereRaw(Db::raw('`goods_sku_sale` > 0'))
                            ->lockForUpdate()
                            ->update([
                                'goods_sku_sale' => new Expression('`goods_sku_sale` - ' . $goods['goods_num']),
                            ]);
                    }

                    if (! $reduceStockStatus) {
                        throw new MineException('扣减库存失败');
                    }
                });
            });
        }, 'goods_sub_lock');
    }

    # 恢复库存
    public function addStock(OrderServiceVo $vo): void
    {
        // 执行失败，恢复库存
        // 锁定的库存进行解锁，真实商品redis库存扣减，数据库扣减
        $this->goodsStockLuaCache->lock(function () use ($vo) {
            // 数据库商品库存减少
            Db::transaction(function () use ($vo) {
                Arr::where($vo->getProductData(), function ($goods) {
                    // 处理单产品
                    if (empty($goods['goods_sku_id'])) {
                        $reduceStockStatus = $this->goodsMapper->getModel()
                            ->where('id', $goods['id'])
                            ->lockForUpdate()
                            ->update([
                                'goods_sale' => new Expression('`goods_sale` + ' . $goods['goods_num']),
                            ]);
                    } else {
                        $reduceStockStatus = $this->goodsSkuMapper->getModel()
                            ->where('goods_sku_id', $goods['goods_sku_id'])
                            ->lockForUpdate()
                            ->update([
                                'goods_sku_sale' => new Expression('`goods_sku_sale` + ' . $goods['goods_num']),
                            ]);
                    }

                    if (! $reduceStockStatus) {
                        throw new MineException('扣减库存失败');
                    }
                });
            });

            // 减少真实库存，解锁锁定的库存
            if ($this->goodsStockLuaCache->addStock($vo->getProductData()) !== 1) {
                throw new MineException('商品恢复库存失败');
            }
        }, 'goods_add_lock');
    }
}
