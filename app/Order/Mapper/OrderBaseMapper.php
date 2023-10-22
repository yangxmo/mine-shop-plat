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

use App\Order\Model\OrderBase;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;
use Mine\MineModel;

class OrderBaseMapper extends AbstractMapper
{
    /**
     * @var OrderBase
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderBase::class;
    }

    /**
     * 订单列表.
     */
    public function getOrderList(array $params, bool $isExport = false): array|LengthAwarePaginatorInterface
    {
        $query = $this->handleSearch($this->model::query(), $params);
        $query->orderByDesc('id')->with(['goods', 'address']);
        if ($isExport) {
            return $query->get()->toArray() ?? [];
        }
        return $query->paginate((int) $params['pageSize'], ['*'], 'page', (int) $params['page']);
    }

    /**
     * 修改订单状态
     */
    #[CacheEvict(prefix: 'OrderInfo', value: '#{id}')]
    public function update(int $id, array $data): bool
    {
        return parent::updateByCondition(['order_no' => $id], $data);
    }

    /**
     * 订单详情.
     */
    #[Cacheable(prefix: 'OrderInfo', value: '#{id}')]
    public function read(int $id, array $column = ['*']): ?MineModel
    {
        return $this->model::query()->where(['order_no' => $id])->with(['goods', 'address', 'orderActionRecord'])->first($column);
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 订单号
        if (! empty($params['order_no'])) {
            $query->where('order_no', '=', $params['order_no']);
        }
        // 订单状态
        if (! empty($params['order_status'])) {
            if (is_array($params['order_status'])) {
                $query->whereIn('order_status', $params['order_status']);
            } else {
                $query->where('order_status', '=', $params['order_status']);
            }
        }
        // 支付状态
        if (! empty($params['order_pay_status'])) {
            $query->where('order_pay_status', '=', $params['order_pay_status']);
        }
        // 退款状态
        if (! empty($params['order_refund_status'])) {
            $query->where('order_refund_status', '=', $params['order_refund_status']);
        }
        // 支付类型
        if (! empty($params['order_pay_type'])) {
            $query->where('order_pay_type', '=', $params['order_pay_type']);
        }
        // 订单关键词(货品名称，订单号)
        if (! empty($params['keyword'])) {
            $query->where('order_no', '=', $params['keyword'])
                ->orWhere(function ($query) use ($params) {
                    $query->whereHas('product', function ($query) use ($params) {
                        $query->where('product_name', 'like', '%' . $params['keyword'] . '%');
                    });
                });
        }
        // 订单金额
        if (! empty($params['order_price'])) {
            $query->where('order_price', '=', $params['order_price']);
        }
        // 收货人名称
        if (! empty($params['consignee_name'])) {
            $query->whereHas('address', function ($query) use ($params) {
                $query->where('receive_user_name', '=', $params['consignee_name']);
            });
        }
        // 收货人手机号
        if (! empty($params['consignee_phone'])) {
            $query->whereHas('address', function ($query) use ($params) {
                $query->where('receive_user_mobile', '=', $params['consignee_phone']);
            });
        }
        // 创建时间
        if (! empty($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [$params['created_at'][0], $params['created_at'][1]]
            );
        }
        // 支付时间
        if (! empty($params['order_pay_time']) && is_array($params['order_pay_time']) && count($params['order_pay_time']) == 2) {
            $query->whereBetween(
                'order_pay_time',
                [$params['order_pay_time'][0], $params['order_pay_time'][1]]
            );
        }

        // 关闭时间
        if (! empty($params['order_cancel_time']) && is_array($params['order_cancel_time']) && count($params['order_cancel_time']) == 2) {
            $query->whereBetween(
                'order_cancel_time',
                [$params['order_cancel_time'][0], $params['order_cancel_time'][1]]
            );
        }
        return $query;
    }
}
