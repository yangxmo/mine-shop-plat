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

namespace App\Goods\Service\Domain;

use App\Goods\Cache\GoodsCartCache;
use App\Goods\Cache\GoodsStockCache;
use App\Goods\Constants\GoodsConstants;
use App\Goods\Mapper\GoodsMapper;
use Hyperf\Codec\Json;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Exception\NormalStatusException;

/**
 * 购物车服务类.
 */
class CartDomainService extends AbstractService
{
    /**
     * @var GoodsMapper
     */
    public $mapper;

    #[Inject]
    public GoodsStockCache $goodsStockCache;

    #[Inject]
    public GoodsCartCache $goodsCartCache;

    public function __construct(GoodsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 购物车列表.
     */
    public function cartList(): array
    {
        $cartDataList = [];
        $cartList = $this->goodsCartCache->getCart();

        if (! empty($cartList)) {
            // 循环购物车数据
            array_map(function ($cartNum, $cartKey) use (&$cartDataList) {
                // 取出商品ID和sku
                $cartKey = explode('_', $cartKey);
                // 获取值
                $goodsId = (int) $cartKey[0];
                $skuId = $cartKey[1] ?? null;
                // 获取商品真实数据
                $goodsInfo = $this->mapper->read($goodsId);
                // 定义商品状态（1可用2不可用3已删除4库存不足）
                $goodsStatus = (int) $goodsInfo['goods_status'] ?? GoodsConstants::GOODS_STATUS_USE_FAIL;
                // 获取商品库存
                $stock = $this->goodsStockCache->getStockCache($goodsId, (string) $skuId ?? null);
                // 判断库存
                if ($stock < (int) $cartNum && $goodsStatus != GoodsConstants::GOODS_STATUS_USE_FAIL) {
                    // 定义商品状态（1可用2不可用3已删除4库存不足）
                    $goodsStatus = GoodsConstants::GOODS_STATUS_STOCK_FAIL;
                }
                // 获取商品信息
                $cartInfo = $this->goodsCartCache->getCartData($goodsId, $skuId);

                // 组装信息(购物车信息存在)
                if (! empty($cartInfo)) {
                    $goodsImage = $goodsInfo['sku'][0]['goods_sku_image'] ?? Json::decode($goodsInfo['goods_image'])[0] ?? '-';
                    $cartDataList[] = [
                        'goods_id' => $goodsId,
                        'goods_status' => $goodsStatus,
                        'goods_num' => $cartInfo['goods_num'] ?? 0,
                        'goods_name' => $goodsInfo['goods_name'] ?? '-',
                        'goods_images' => $goodsImage ?? '-',
                        'goods_price' => floatval($goodsInfo['goods_price'] ?? 0.00),
                    ];
                } else {
                    // 删除购物车不存在的数据
                    $this->goodsCartCache->reduceCart($goodsId, $skuId, 9999999);
                }
            }, $cartList, array_keys($cartList));
        }

        return $cartDataList;
    }

    /**
     * 购物车新增.
     */
    public function saveCart(int $goodsId, ?string $skuId, int $num = 1): bool
    {
        // 获取商品库存
        $stock = $this->goodsStockCache->getStockCache($goodsId, $skuId);
        // 判断当前已加库存与待加库存 是否大于总库存
        if (! $stock || $num > $stock) {
            throw new NormalStatusException(t('cart.goods_stock_lack'));
        }
        $cartData = [
            'goods_id' => $goodsId,
            'goods_num' => $num,
        ];

        // 写入缓存
        return $this->goodsCartCache->setCartData($goodsId, $skuId, $cartData);
    }

    /**
     * 购物车减少.
     */
    public function reduceCart(int $goodsId, string $skuId): bool
    {
        // 获取当前已添加购车的库存总数
        $cartInfo = $this->goodsCartCache->getCartData($goodsId, $skuId);

        if (! empty($cartInfo)) {
            --$cartInfo['goods_num'];

            if (! $cartInfo['goods_num']) {
                return $this->goodsCartCache->delCartData($goodsId, $skuId);
            }
        }

        return $this->goodsCartCache->setCartData($goodsId, $skuId, $cartInfo);
    }

    /**
     * 购物车清空.
     */
    public function clearCart(): bool
    {
        // 写入缓存
        return $this->goodsCartCache->clearCart();
    }
}
