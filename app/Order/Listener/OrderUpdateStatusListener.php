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

use App\Order\Event\OrderUpdateStatusEvent;
use App\Order\Service\OrderBaseService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\ModelListener\AbstractListener;

#[Listener]
class OrderUpdateStatusListener extends AbstractListener
{
    public function listen(): array
    {
        return [
            OrderUpdateStatusEvent::class,
        ];
    }

    public function process(object $event): void
    {
        /**
         * @var OrderUpdateStatusEvent $event
         */
        $orderEvent = $event;

        $orderNo = $orderEvent->getOrderNo();
        $orderStatus = $orderEvent->getStatus();

        $orderService = container()->get(OrderBaseService::class);

        $orderInfo = $orderService->orderInfo($orderNo);

        // 修改订单状态
        $orderInfo && $orderService->changeStatus($orderNo, (string) $orderStatus, 'order_status');
    }
}
