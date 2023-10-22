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

use App\Order\Constant\OrderStatusCode;
use App\Order\Dto\OrderDto;
use App\Order\Mapper\OrderLogisticsMapper;
use App\Order\Model\OrderBase;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Mine\Exception\NormalStatusException;
use Mine\MineCollection;
use Psr\Http\Message\ResponseInterface;

class OrderDeliveryService extends AbstractService
{
    public $mapper;

    #[Inject]
    public OrderBaseService $orderBaseService;

    public function __construct(OrderLogisticsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /*
     * 订单发货
     */
    #[Transaction]
    public function delivery(array $params): bool
    {
        /** @var OrderBase $orderInfo */
        $orderInfo = $this->orderBaseService->orderInfo((int) $params['order_no']);
        // 检查订单
        if ($orderInfo->order_status != OrderStatusCode::ORDER_STATUS_PROCESSED) {
            throw new NormalStatusException('订单发货失败，不是待发货订单');
        }
        // 修改订单状态
        $upStatus = $this->orderBaseService->changeStatus($orderInfo->id, (string) OrderStatusCode::ORDER_STATUS_SHIPPED, 'order_status');
        // 发货
        $deliveryStatus = $this->mapper->delivery((int) $orderInfo->order_no, $params);

        return $upStatus && $deliveryStatus;
    }

    /**
     * 订单导出.
     */
    public function orderExport(array $params): ResponseInterface
    {
        $result = $this->getList($params, true);
        return (new MineCollection())->export(OrderDto::class, date('YmdHis'), $this->handleOrderExportData($result));
    }

    /**
     * 处理订单导出数据.
     */
    private function handleOrderExportData(array $orderData): array
    {
        if (empty($orderData)) {
            return $orderData;
        }
        $orderList = [];
        foreach ($orderData as $key => $item) {
            if (! empty($item['product']) && is_array($item['product'])) {
                foreach ($item['product'] as $val) {
                    $orderList[$key]['order_no'] = $item['order_no'];
                    $orderList[$key]['order_price'] = $item['order_price'];
                    $orderList[$key]['order_status'] = $item['order_status'];
                    $orderList[$key]['order_pay_type'] = $item['order_pay_type'];
                    $orderList[$key]['created_at'] = $item['created_at'];
                    $orderList[$key]['product_name'] = $val['product_name'];
                    $orderList[$key]['product_num'] = $val['product_num'];
                    $orderList[$key]['receive_user_name'] = $item['address']['receive_user_name'];
                    $orderList[$key]['receive_user_mobile'] = $item['address']['receive_user_mobile'];
                    $orderList[$key]['receive_user_province'] = $item['address']['receive_user_province'];
                    $orderList[$key]['receive_user_city'] = $item['address']['receive_user_city'];
                    $orderList[$key]['receive_user_street'] = $item['address']['receive_user_street'];
                    $orderList[$key]['receive_user_address'] = $item['address']['receive_user_address'];
                }
            }
        }
        return $orderList;
    }
}
