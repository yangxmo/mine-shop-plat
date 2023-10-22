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
namespace App\Order\Vo;

class OrderServiceVo
{
    // 用户ID
    public int $userId;

    // 企业ID
    public string $tenantId;

    // 商品数据
    public array $goodsData;

    // 产品总运费
    public float $orderFreightPrice = 0.00;

    // 订单总金额
    public float $orderPrice = 0.00;

    // 优惠金额
    public float $orderDiscountPrice = 0.00;

    // 订单总支付金额
    public float $orderPayPrice = 0.00;

    // 是否购物车
    public bool $isCart = false;

    // 订单号
    public int $orderNo;

    public OrderAddressVo $orderFreightVo;

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setOrderNo(int $orderNo): void
    {
        $this->orderNo = $orderNo;
    }

    public function setTenantId(string $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    public function setGoodsData(array $goodsData): void
    {
        $this->goodsData = $goodsData;
    }

    public function setOrderFreightPrice(float $price): void
    {
        $this->orderFreightPrice = $price;
    }

    public function setOrderPrice(float $price): void
    {
        $this->orderPrice = $price;
    }

    public function setOrderDiscountPrice(float $price): void
    {
        $this->orderDiscountPrice = $price;
    }

    public function setOrderPayPrice(float $price): void
    {
        $this->orderPayPrice = $price;
    }

    public function setOrderFreight(OrderAddressVo $orderFreightVo): void
    {
        $this->orderFreightVo = $orderFreightVo;
    }

    public function setIsCart(bool $isCart): void
    {
        $this->isCart = $isCart;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function getGoodsData(): array
    {
        return $this->goodsData;
    }

    public function getOrderFreightPrice(): float
    {
        return $this->orderFreightPrice;
    }

    public function getOrderPrice(): float
    {
        return $this->orderPrice;
    }

    public function getOrderDiscountPrice(): float
    {
        return $this->orderDiscountPrice;
    }

    public function getOrderPayPrice(): float
    {
        return $this->orderPayPrice;
    }

    public function getIsCart(): bool
    {
        return $this->isCart;
    }

    public function getOrderNo(): int
    {
        return $this->orderNo;
    }
}
