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
namespace App\Order\Assemble;

use App\Order\Vo\OrderServiceVo;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class OrderPayRecordAssemble
{
    /**
     * 构建订单支付记录
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function buildOrderPayRecordData(OrderServiceVo $vo): array
    {
        return [
            'order_no' => $vo->getOrderNo(),
            'pay_trade_no' => snowflake_id(),
            'pay_price' => $vo->getOrderPrice(),
            'pay_params' => '',
            'pay_callback_params' => '',
        ];
    }
}
