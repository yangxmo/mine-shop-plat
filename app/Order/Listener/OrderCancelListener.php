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

namespace App\Order\Listener;

use App\Order\Event\OrderCancelEvent;
use App\Order\Service\OrderBaseService;
use App\Order\Service\OrderPayService;
use App\Order\Service\OrderRefundService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\ModelListener\AbstractListener;

#[Listener]
class OrderCancelListener extends AbstractListener
{
    public function listen(): array
    {
        return [
            OrderCancelEvent::class,
        ];
    }

    public function process(object $event): void
    {
        /**
         * @var OrderCancelEvent $event
         */
        $orderEvent = $event;

        $orderNo = $orderEvent->getOrderNo();

        $orderService = container()->get(OrderBaseService::class);
        $orderPayService = container()->get(OrderPayService::class);
        $orderRefundService = container()->get(OrderRefundService::class);
        // 获取信息
        $orderInfo = $orderService->orderInfo($orderNo);
        // 获取支付类型
        $payType = $orderInfo->order_pay_type;
        // 获取支付记录
        $payRecord = $orderPayService->getPayRecord($orderNo);
        // 调用退款
        $orderRefundService->refund([
            'order_no' => $orderNo,
            'pay_type' => $payType,
        ]);
    }
}
