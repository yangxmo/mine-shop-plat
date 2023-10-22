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
namespace App\Order\Service\Preview\Interface;

use App\Order\Vo\OrderServiceVo;

interface OrderPreviewInterface
{
    public function init(OrderServiceVo $orderServiceVo): self;

    // 获取确认订单页信息
    public function getPreviewOrder(): array;

    // 检查商品
    public function checkOrderProduct(): self;

    // 检查商品总价
    public function checkOrderProductPayPrice(): self;
}
