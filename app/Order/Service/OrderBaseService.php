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

namespace App\Order\Service;

use App\Order\Assemble\OrderExportAssemble;
use App\Order\Constant\OrderErrorCode;
use App\Order\Constant\OrderPayStatusCode;
use App\Order\Constant\OrderStatusCode;
use App\Order\Dto\OrderDto;
use App\Order\Mapper\OrderBaseMapper;
use App\Order\Mapper\OrderGoodsMapper;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Mine\Exception\NormalStatusException;
use Mine\MineCollection;
use Psr\Http\Message\ResponseInterface;

class OrderBaseService extends AbstractService
{
    public $mapper;

    #[Inject]
    public OrderGoodsMapper $orderGoodsMapper;

    public function __construct(OrderBaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取订单列表.
     */
    public function getOrderList(array $params, bool $isExport = false): array
    {
        $params['status'] = $this->transformOrderStatus($params['status'] ?? '');
        $paginateOrData = $this->mapper->getOrderList($params, $isExport);
        if ($isExport) {
            return $paginateOrData;
        }
        return $this->mapper->setPaginate($paginateOrData);
    }

    /**
     * 获取订单产品
     */
    public function getGoodsList(int $orderNo): array
    {
        $result = [];
        $fields = ['id', 'order_no', 'goods_sku_name', 'goods_sku_value', 'goods_sku_no'];
        $list = $this->orderGoodsMapper->getList(['order_no' => $orderNo, 'select' => $fields], false);

        if ($list) {
            foreach ($list as $value) {
                $result[] = [
                    'label' => $value['goods_sku_no'],
                    'value' => $value['goods_sku_name'],
                ];
            }
        }

        return $result;
    }

    /**
     * 更新订单状态
     */
    public function changeStatus(int $id, string $value, string $filed = 'status'): bool
    {
        return $this->mapper->updateData($id, [$filed => $value]);
    }

    /**
     * 订单取消.
     */
    #[Transaction]
    public function orderCancel(int $orderNo): void
    {
        // 查看订单状态
        $info = $this->orderInfo($orderNo);

        if ($info->order_pay_status != OrderPayStatusCode::PAY_STATUS_SUCCESS) {
            // 订单未支付
            throw new NormalStatusException(t('order.order_no_pay'), OrderErrorCode::ORDER_NOT_PAY_ERROR);
        }
        // 订单在退款审核中
        if ($info->order_refund_status == OrderStatusCode::ORDER_BASE_REFUND_AUDIT_RUNNING) {
            // 订单审核中
            throw new NormalStatusException(t('order.order_refund_running'), OrderErrorCode::ORDER_REFUND_RUNNING);
        }
        // 改订单状态无法退款
        if (in_array($info->order_status, [OrderStatusCode::ORDER_STATUS_PROCESSED, OrderStatusCode::ORDER_STATUS_SHIPPED])) {
            // 改订单状态无法退款
            throw new NormalStatusException(t('order.order_refund_status_error'), OrderErrorCode::ORDER_REFUND_ERROR);
        }

        // 更改订单状态
        $this->mapper->updateData($info->id, ['order_status' => OrderStatusCode::ORDER_STATUS_SELLER_CANCEL]);
        // TODO 执行退款
    }

    /**
     * 订单导出.
     */
    public function orderExport(array $params): ResponseInterface
    {
        $result = $this->getOrderList($params, true);
        return (new MineCollection())->export(OrderDto::class, date('YmdHis'), OrderExportAssemble::handleOrderExportData($result));
    }

    /**
     * 订单状态转换.
     * @return mixed|string
     */
    private function transformOrderStatus(string $status): mixed
    {
        // all全部订单，pendingPayment待付款，processed待发货
        // shipped待收货，ordered已完成，closed已关闭
        $transformStatus = [
            'all' => '',
            'pendingPayment' => OrderStatusCode::ORDER_STATUS_TRUE,
            'processed' => OrderStatusCode::ORDER_STATUS_PROCESSED,
            'shipped' => OrderStatusCode::ORDER_STATUS_SHIPPED,
            'ordered' => OrderStatusCode::ORDER_STATUS_SUCCESS,
            'closed' => [OrderStatusCode::ORDER_STATUS_CANCEL, OrderStatusCode::ORDER_STATUS_SYSTEM_CANCEL],
        ];
        return $transformStatus[$status] ?? '';
    }
}
