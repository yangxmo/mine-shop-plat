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

class OrderExportAssemble
{
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
