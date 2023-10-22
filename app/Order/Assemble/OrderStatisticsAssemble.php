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

use App\Order\Constant\OrderPayStatusCode;
use App\Order\Constant\OrderStatusCode;

class OrderStatisticsAssemble
{

    /**
     * 处理订单数据.
     */
    public static function handleOrderData(array $data): array
    {
        $orderCollect = \Hyperf\Collection\collect($data);
        // 选品数
        $selectionCount = '0';
        // 交易金额
        $gmv = $orderCollect->where('order_pay_status', '=', OrderPayStatusCode::PAY_STATUS_SUCCESS)->sum('order_pay_price');
        // 订单生成数
        $orderGenerateCount = $orderCollect->count();
        // 支付订单数
        $payCount = $orderCollect->where('order_pay_status', '=', OrderPayStatusCode::PAY_STATUS_SUCCESS)->count();
        // 支付买家数
        $payBuyCount = $orderCollect->where('order_pay_status', '=', OrderPayStatusCode::PAY_STATUS_SUCCESS)->groupBy('order_create_user_id')->count();
        // cvr 支付转化率 （实际支付数 / 访客人数）× 100%
        $visitorCount = $orderCollect->where('order_status', '=', OrderStatusCode::ORDER_STATUS_TRUE)->count();
        $cvr = $visitorCount ? bcdiv((string) $payCount, (string) $visitorCount) : '0';
        // 售后订单数
        $afterSalesCount = '0';
        // aov 客单价 销售总额 / 订单数
        $aov = $payCount ? bcdiv((string) $gmv, (string) $payCount) : '0';
        return [
            'selection_count' => $selectionCount,
            'gmv' => $gmv,
            'order_generate_count' => $orderGenerateCount,
            'pay_count' => $payCount,
            'pay_buy_count' => $payBuyCount,
            'cvr' => $cvr,
            'after_sales_count' => $afterSalesCount,
            'aov' => $aov,
        ];
    }

    /**
     * 处理订单导出数据.
     */
    public static function handleOrderExportData(array $orderData): array
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
