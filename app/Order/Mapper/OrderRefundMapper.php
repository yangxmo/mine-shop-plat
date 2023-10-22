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

namespace App\Order\Mapper;

use App\Order\Model\OrderRefund;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Mine\Abstracts\AbstractMapper;

class OrderRefundMapper extends AbstractMapper
{
    /**
     * @var OrderRefund
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderRefund::class;
    }

    /**
     * 获取售后订单详情.
     */
    #[Cacheable(prefix: 'RefundOrderInfo', value: '#{orderRefundNo}')]
    public function info(int $orderRefundNo): Model|Builder|null
    {
        return $this->model::where('refund_order_no', $orderRefundNo)->with(['order', 'order.userInfo', 'goods'])->first();
    }

    /**
     * 修改.
     */
    #[CacheEvict(prefix: 'RefundOrderInfo', value: '#{id}')]
    public function update(int $id, array $data): bool
    {
        return parent::update($id, $data);
    }

    public function handleSearch(Builder $query, array $params): Builder
    {
        // 退款单号
        if (! empty($params['refund_order_no'])) {
            $query->where('refund_order_no', $params['refund_order_no']);
        }
        // 订单号
        if (! empty($params['order_no'])) {
            $query->where('order_no', $params['order_no']);
        }
        // 退款交易单号
        if (! empty($params['refund_trade_no'])) {
            $query->where('refund_trade_no', $params['refund_trade_no']);
        }
        // 审核状态
        if (! empty($params['refund_examine_status'])) {
            $query->where('refund_examine_status', $params['refund_examine_status']);
        }
        // 退款状态
        if (! empty($params['refund_status'])) {
            $query->where('refund_status', $params['refund_status']);
        }
        // 申请时间
        if (! empty($params['refund_apply_time']) && is_array($params['refund_apply_time']) && count($params['refund_apply_time']) == 2) {
            $query->whereBetween(
                'refund_apply_time',
                [$params['refund_apply_time'][0], $params['refund_apply_time'][1]]
            );
        }
        // 退款时间
        if (! empty($params['refund_price_time']) && is_array($params['refund_price_time']) && count($params['refund_price_time']) == 2) {
            $query->whereBetween(
                'refund_price_time',
                [$params['refund_price_time'][0], $params['refund_price_time'][1]]
            );
        }

        return $query;
    }
}
