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
namespace App\Order\Service\Preview\Handler;

use App\Goods\Constants\GoodsConstants;
use App\Goods\Model\Goods;
use App\Goods\Service\Domain\GoodsDomainService;
use App\Goods\Service\Domain\GoodsSkuDomainService;
use App\Order\Cache\GoodsStockLuaCache;
use App\Order\Cache\OrderCache;
use App\Order\Service\Preview\Abstract\OrderPreviewAbstract;
use App\Order\Trait\OrderPriceTrait;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;
use HyperfHelper\Dependency\Annotation\Dependency;

use function Api\Service\Order\Preview\Handler\phpt;

use const Api\Service\Order\Preview\Handler\OrderPreviewHandler;

#[Dependency]
class OrderPreviewHandler extends OrderPreviewAbstract
{
    use OrderPriceTrait;

    #[Inject]
    protected GoodsDomainService $goodsDomainService;

    #[Inject]
    protected GoodsSkuDomainService $goodsSkuDomainService;

    #[Inject]
    protected GoodsStockLuaCache $goodsStockLuaCache;

    # 检查订单产品信息
    public function checkOrderProduct(): OrderPreviewAbstract
    {
        // 检查产品库存
        $checkStock = $this->goodsStockLuaCache->checkStock($this->orderVo->getGoodsData());
        // 库存不足
        if (! $checkStock) {
            $this->setOrderError(t('order.product_stock_no_free'));
        }
        // 检查商品状态
        Arr::where($this->orderVo->getGoodsData(), function ($goods) {
            /** @var Goods $goodsInfo */
            $goodsInfo = $this->goodsDomainService->read($goods['goods_id']);
            if (! empty($goods['goods_sku_id'])) {
                $goodsSkuInfo = $this->goodsDomainService->read($goods['goods_id']);
            }
            // 产品不存在
            if (empty($goodsInfo) || (! empty($goodsInfo['goods_sku_id']) && empty($goodsSkuInfo))) {
                $this->setOrderError(t('order.product_not_found'));
            }
            // 产品状态异常
            if ($goodsInfo->goods_status != GoodsConstants::GOODS_STATUS_USE) {
                $this->setOrderError(OrderPreviewHandler . phpt('order.goods_use_fail') . $goodsInfo->goods_name);
            }
        });

        return $this;
    }

    # 计算订单产品价格
    public function checkOrderProductPayPrice(): OrderPreviewAbstract
    {
        // 初始化金额
        $allProductPrice = $allFreightPrice = 0;

        Arr::where($this->orderVo->getGoodsData(), function ($goods) use (&$allProductPrice, &$allFreightPrice) {
            // 计算产品金额
            $this->calculateOrderPrice($allProductPrice, $goods['goods_num'], $goods['goods_price']);
            // 计算运费
            $this->calculateOrderFreightPrice($allProductPrice, $goods['goods_num'], $goods['goods_price']);
        });

        // 合并总订单金额
        $allOrderPrice = floatval(bcadd((string) $allFreightPrice, (string) $allProductPrice, 2));
        // 合并支付金额
        $allOrderPayPrice = floatval(bcadd((string) $allFreightPrice, (string) $allProductPrice, 2));
        // 设置订单金额
        $this->orderVo->setOrderPrice($allOrderPrice);
        // 设置订单支付金额
        $this->orderVo->setOrderPayPrice($allOrderPayPrice);
        // 设置运费
        $this->orderVo->setOrderFreightPrice($allFreightPrice);

        return $this;
    }

    # 构建所需产品信息
    public function buildGoodsInfo(): OrderPreviewAbstract
    {
        $newGoodsData = [];
        $goodsData = $this->orderVo->getGoodsData();

        // 定义rpc调用时候租户
        Arr::where($goodsData, function ($value) use (&$newGoodsData) {
            // 获取信息
            $goodsInfo = $this->goodsDomainService->read($value['id']);
            // 获取sku信息
            $goodsSkuInfo = $this->goodsSkuDomainService->read($value['goods_sku_id'] ?? null);
            // 产品不存在
            if (empty($goodsInfo) || ! empty($goodsSkuId) && empty($goodsInfo)) {
                $this->setOrderError(t('order.product_not_found'));
            }
            // 产品sku信息
            $goodsName = $goodsInfo['goods_name'] ?? '';
            $goodsSkuName = $goodsSkuInfo['goods_sku_name'] ?? '';
            $goodsSkuValue = $goodsSkuInfo['goods_sku_value'] ?? '';
            $goodsPrice = $goodsSkuInfo['goods_sku_price'] ?? $goodsInfo['goods_price'] ?? 0.00;
            $goodsImage = $goodsSkuInfo['goods_images'][0] ?? $goodsInfo['goods_sku_images'] ?? '';
            // 组装产品
            $newGoodsData[] = [
                'goods_id' => (int) $value['id'],
                'goods_name' => $goodsName,
                'goods_sku_name' => $goodsSkuName ?? $goodsName ?? '',
                'goods_sku_value' => $goodsSkuValue ?? '',
                'goods_image' => $goodsImage,
                'goods_price' => (float) $goodsPrice,
                'goods_num' => (int) $value['goods_num'],
                'goods_sku_id' => (int) $value['goods_sku_id'],
                'goods_freight_price' => 0,
                'goods_discount_price' => 0,
                'goods_pay_price' => 0,
            ];
        });

        $this->orderVo->goodsData = $newGoodsData;

        return $this;
    }

    # 订单后续操作
    public function after(string $orderNo, array $confirmOrder): void
    {
        $orderCache = container()->get(OrderCache::class);
        $orderCache->setConfirmCache($orderNo, $confirmOrder);
    }
}
