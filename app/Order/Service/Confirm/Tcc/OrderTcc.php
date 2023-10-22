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
namespace App\Order\Service\Confirm\Tcc;

use App\Order\Model\OrderBase;
use App\Order\Service\Confirm\Service\OrderService;
use App\Order\Vo\OrderServiceVo;
use Hyperf\Database\Model\Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tcc\TccTransaction\TccOption;

class OrderTcc extends TccOption
{
    protected int $orderId;

    protected OrderServiceVo $vo;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function try(): Model|OrderBase
    {
        # 获取依赖数据
        $this->vo = $this->tcc->get(BuildOrderTcc::class);

        # 创建订单
        /** @var OrderService $service */
        $service = make(OrderService::class);
        $order = $service->createOrder($this->vo);
        $this->orderId = (int) $order->id;

        # 返回订单
        return $order;
    }

    public function confirm()
    {
        # 空提交
    }

    public function cancel(): void
    {
        # 删除订单
        $service = new OrderService();
        $service->deleteOrder($this->orderId);
    }
}
