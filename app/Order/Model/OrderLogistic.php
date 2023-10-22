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
namespace App\Order\Model;

use Mine\MineModel;

/**
 * @property int $order_no
 * @property string $logistics_name
 * @property string $logistics_no
 * @property int $sku_id
 * @property string $delivered_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderLogistic extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_logistics';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_no', 'logistics_name', 'logistics_no', 'sku_id', 'delivered_time', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_no' => 'integer', 'sku_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
