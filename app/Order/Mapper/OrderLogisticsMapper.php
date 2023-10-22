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

use App\Order\Model\OrderLogistic;
use Carbon\Carbon;
use Hyperf\Cache\Annotation\CacheEvict;
use Mine\Abstracts\AbstractMapper;

class OrderLogisticsMapper extends AbstractMapper
{
    /**
     * @var OrderLogistic
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderLogistic::class;
    }

    // 订单发货
    #[CacheEvict(prefix: 'OrderInfo', value: '#{orderNo}')]
    public function delivery(int $orderNo, array $params): bool
    {
        return $this->updateByCondition(
            ['order_no' => $orderNo],
            [
                'logistics_name' => $params['logistics_name'],
                'logistics_no' => $params['logistics_no'],
                'sku_id' => $params['sku_id'],
                'delivered_time' => Carbon::now()->toDateTimeString(),
            ]
        );
    }
}
