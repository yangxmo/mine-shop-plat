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

namespace App\Order\Request;

use Hyperf\Validation\Rule;
use Mine\MineFormRequest;

/**
 * 订单验证数据类.
 */
class OrderRefundRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [
        ];
    }

    /**
     * 订单列表.
     * @return array[]
     */
    public function indexRules(): array
    {
        return [
            'page' => ['required', 'integer'],
            'pageSize' => ['required', 'integer'],
            'refund_apply_time' => ['nullable', 'date_format:Y-m-d'],
            'refund_price_time' => ['nullable', 'date_format:Y-m-d'],
            'refund_examine_status' => ['nullable', 'numeric'],
            'refund_status' => ['nullable', 'numeric'],
            'refund_order_no' => ['nullable', 'string'],
            'order_no' => ['nullable', 'string'],
        ];
    }

    /**
     * 订单导出.
     * @return array[]
     */
    public function exportRules(): array
    {
        $rules = $this->indexRules();
        unset($rules['page'], $rules['pageSize']);
        return $rules;
    }

    /**
     * 订单详情.
     * @return array[]
     */
    public function readRules(): array
    {
        return [
            'refund_order_no' => ['required', Rule::exists('order_refund', 'refund_order_no')],
        ];
    }

    public function auditRules(): array
    {
        return [
            'refund_order_no' => ['required', 'integer', Rule::exists('order_refund')],
            'refund_examine_status' => ['required', 'integer', 'in:1,2'],
            'refund_examine_fail_msg' => ['required_with:refund_examine_status,1'],
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'refund_order_no' => '订单号',
            'order_price' => '订单金额',
            'order_time_begin' => '下单开始时间',
            'order_time_end' => '下单结算时间',
            'consignee_name' => '收获人名称',
            'consignee_phone' => '收货人电话',
            'keyword' => '关键词',
            'status' => '订单状态',
        ];
    }
}
