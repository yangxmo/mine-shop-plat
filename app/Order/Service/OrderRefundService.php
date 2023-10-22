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
use App\Order\Mapper\OrderRefundMapper;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;
use Mine\Exception\MineException;
use Mine\MineCollection;
use Psr\Http\Message\ResponseInterface;

class OrderRefundService extends AbstractService
{
    public $mapper;

    #[Inject]
    public OrderBaseService $orderBaseService;

    public function __construct(OrderRefundMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 订单售后信息.
     */
    public function orderInfo(int $orderNo): Model|Builder|null
    {
        return $this->mapper->info($orderNo);
    }

    /**
     * 审核退款订单.
     */
    #[Transaction]
    public function audit(array $params): bool
    {
        $orderInfo = $this->orderInfo($params['refund_order_no']);
        // 判定审核状态
        if ($orderInfo->refund_examine_status != OrderStatusCode::ORDER_REFUND_STATUS_STAY_AUDIT) {
            throw new MineException('订单状态异常,审核失败');
        }

        // 修改订单基础退款状态
        if ($params['refund_examine_status'] == OrderStatusCode::ORDER_REFUND_STATUS_AUDIT_PASS) {
            $this->orderBaseService->mapper->updateData($orderInfo->order_no, ['order_refund_status' => OrderStatusCode::ORDER_BASE_REFUND_AUDIT_SUCCESS]);
        }

        // 修改审核状态
        return $this->mapper->update($params['refund_order_no'], $params);
    }

    /**
     * 退款.
     */
    public function refund(array $params): bool
    {
        // TODO 调用退款

        return true;
    }

    /**
     * 退货审核.
     */
    public function refundAudio(array $params): bool
    {
        // TODO 退货审核

        return true;
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
            if (!empty($item['product']) && is_array($item['product'])) {
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
