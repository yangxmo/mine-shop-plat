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

use App\Order\Model\OrderGoods;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

class OrderGoodsMapper extends AbstractMapper
{
    /**
     * @var OrderGoods
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderGoods::class;
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
        return $query;
    }
}
