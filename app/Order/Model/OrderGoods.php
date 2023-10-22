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
 * @property string $goods_name
 * @property string $goods_sku_name
 * @property string $goods_sku_value
 * @property string $goods_image
 * @property int $goods_no
 * @property int $goods_sku_no
 * @property int $goods_num
 * @property string $goods_price
 * @property string $goods_freight_price
 * @property string $goods_discount_price
 * @property string $goods_pay_price
 * @property int $goods_order_status
 * @property int $goods_refund_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderGoods extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_goods';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_no', 'goods_name', 'goods_sku_name', 'goods_sku_value', 'goods_image', 'goods_no', 'goods_sku_no', 'goods_num', 'goods_price', 'goods_freight_price', 'goods_discount_price', 'goods_pay_price', 'goods_order_status', 'goods_refund_status', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_no' => 'integer', 'goods_no' => 'integer', 'goods_sku_no' => 'integer', 'goods_num' => 'integer', 'goods_price' => 'decimal:2', 'goods_freight_price' => 'decimal:2', 'goods_discount_price' => 'decimal:2', 'goods_pay_price' => 'decimal:2', 'goods_order_status' => 'integer', 'goods_refund_status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
