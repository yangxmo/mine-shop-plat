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

use App\Order\Model\OrderPayRecord;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Mine\Abstracts\AbstractMapper;

class OrderPayRecordMapper extends AbstractMapper
{
    /**
     * @var OrderPayRecord
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderPayRecord::class;
    }

    public function getRecordByOrderNo(string $orderNo): Model|Builder|null
    {
        return $this->model::where(['order_no' => $orderNo])->first();
    }

    public function updateRecordByOrderNo(string $orderNo, array $params): int
    {
        return $this->model::where(['order_no' => $orderNo])->update($params);
    }
}
