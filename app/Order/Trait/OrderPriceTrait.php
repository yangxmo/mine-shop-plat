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
namespace App\Order\Trait;

trait OrderPriceTrait
{
    /**
     * 计算产品价格
     * @param float $orderPrice 订单计算字段
     * @param int $goodsNum 商品购买数量
     * @param float $goodsPrice 商品售价
     */
    public function calculateOrderPrice(float &$orderPrice, int $goodsNum, float $goodsPrice): void
    {
        $price = floatval(bcmul((string) $goodsNum, (string) $goodsPrice, 2));

        $orderPrice = floatval(bcadd((string) $orderPrice, (string) $price, 2));
    }

    /**
     * 计算运费价格
     * @param float $orderFreightPrice 运费计算字段
     * @param int $goodsNum 商品购买数量
     * @param float $freightPrice 商品设置的运费金额
     */
    public function calculateOrderFreightPrice(float &$orderFreightPrice, int $goodsNum, float $freightPrice): void
    {
        $price = floatval(bcmul((string) $goodsNum, (string) $freightPrice, 2));

        $orderFreightPrice = floatval(bcadd((string) $orderFreightPrice, (string) $price, 2));
    }
}
