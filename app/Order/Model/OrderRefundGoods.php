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
 * @property int $refund_order_no
 * @property string $refund_goods_name
 * @property string $refund_goods_image
 * @property string $refund_goods_no
 * @property string $refund_goods_sku_no
 * @property int $refund_goods_num
 * @property string $refund_goods_old_price
 * @property string $refund_goods_price
 * @property string $refund_remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderRefundGoods extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_refund_goods';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['refund_order_no', 'refund_goods_name', 'refund_goods_image', 'refund_goods_no', 'refund_goods_sku_no', 'refund_goods_num', 'refund_goods_old_price', 'refund_goods_price', 'refund_remark', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['refund_order_no' => 'integer', 'refund_goods_num' => 'integer', 'refund_goods_old_price' => 'decimal:2', 'refund_goods_price' => 'decimal:2', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
