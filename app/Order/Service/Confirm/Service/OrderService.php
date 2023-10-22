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

namespace App\Order\Service\Confirm\Service;

use App\Order\Assemble\OrderAssemble;
use App\Order\Mapper\OrderBaseMapper;
use App\Order\Model\OrderBase;
use App\Order\Vo\OrderServiceVo;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Query\Expression;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Mine\Annotation\Transaction;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class OrderService
{
    #[Inject]
    protected OrderBaseMapper $orderBaseMapper;

    /**
     * 创建订单
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Transaction]
    public function createOrder(OrderServiceVo $vo): Model|OrderBase
    {
        // 订单基础信息
        $orderData = OrderAssemble::buildOrderData($vo);
        // 订单商品信息
        $goodsData = OrderAssemble::buildOrderProductData($vo);
        // 订单地址信息
        $addressData = OrderAssemble::buildOrderAddressData($vo);
        // 创建订单
        $order = $this->orderBaseMapper->create($orderData);
        // 创建商品
        $order->goods()->insert($goodsData);
        // 创建地址
        $order->address()->create($addressData);

        return $order;
    }

    # 删除订单
    #[Transaction]
    public function deleteOrder(int $orderId): void
    {
        Db::table('tcc_order')
            ->where('id', $orderId)
            ->delete();
    }

    # 创建订单消息
    #[Transaction]
    public function createMessage(int $orderId, string $message): int
    {
        return Db::table('tcc_order_message')
            ->insertGetId([
                'order_id' => $orderId,
                'message' => '订单创建成功, 通知管理员',
            ]);
    }

    # 删除订单消息
    #[Transaction]
    public function deleteMessage(int $msgId): void
    {
        Db::table('tcc_order_message')
            ->where('id', $msgId)
            ->delete();
    }

    # 增加订单统计
    #[Transaction]
    public function incOrderStatistics(): void
    {
        Db::table('tcc_order_statistics')
            ->where('id', 1)
            ->update(['order_num' => new Expression('order_num + 1')]);
    }

    # 减少订单统计
    #[Transaction]
    public function decOrderStatistics(): void
    {
        Db::table('tcc_order_statistics')
            ->where('id', 1)
            ->update(['order_num' => new Expression('order_num - 1')]);
    }
}
