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
namespace App\Goods\Listener;

use App\Goods\Cache\GoodsStockCache;
use App\Goods\Event\GoodsSkuEvent;
use App\Goods\Mapper\GoodsSkuMapper;
use App\Goods\Model\GoodsSku;
use Hyperf\Database\Model\Events\Deleted;
use Hyperf\Database\Model\Events\Updated;
use Hyperf\Event\Annotation\Listener;
use Hyperf\ModelListener\AbstractListener;

#[Listener]
class GoodsSkuListener extends AbstractListener
{
    public function listen(): array
    {
        return [
            GoodsSkuEvent::class,
        ];
    }

    public function process(object $event): void
    {
        /** @var Deleted|Updated $modelEvent */
        $modelEvent = $event->modelEvent;
        /** @var GoodsSku $sku */
        $sku = $modelEvent->getModel();

        /** @var GoodsSkuMapper $goodsSkuMapper */
        $goodsSkuMapper = make(GoodsSkuMapper::class);
        /** @var GoodsStockCache $stockCache */
        $stockCache = make(GoodsStockCache::class);

        if ($modelEvent instanceof Deleted) {
            // 执行空方法删除缓存
            $goodsSkuMapper->updateOrDelete($sku->goods_sku_id);
            $stockCache->delStockCache((int) $sku['goods_no'], (int) $sku['goods_sku_id']);
        } else {
            $stockCache->setStockCache((int) $sku->goods_no, $sku->goods_sku_id, $sku->goods_sku_sale);
        }
    }
}
