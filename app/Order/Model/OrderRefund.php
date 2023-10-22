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

use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\HasMany;
use Mine\MineModel;

/**
 * @property int $refund_order_no
 * @property int $order_no
 * @property string $refund_trade_no
 * @property string $refund_price
 * @property string $refund_apply_time
 * @property string $refund_price_time
 * @property int $refund_examine_status
 * @property string $refund_examine_fail_msg
 * @property int $refund_status
 * @property int $refund_type
 * @property string $refund_order_tenant_no
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderRefund extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_refund';

    protected string $primaryKey = 'refund_order_no';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['refund_order_no', 'order_no', 'refund_trade_no', 'refund_price', 'refund_apply_time', 'refund_price_time', 'refund_examine_status', 'refund_examine_fail_msg', 'refund_status', 'refund_type', 'refund_order_tenant_no', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['refund_order_no' => 'integer', 'order_no' => 'integer', 'refund_price' => 'decimal:2', 'refund_examine_status' => 'integer', 'refund_status' => 'integer', 'refund_type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 订单.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(OrderBase::class, 'order_no', 'order_no')
            ->select(['id', 'order_no', 'order_price', 'order_create_user_id', 'order_discount_price', 'order_freight_price', 'order_pay_price', 'order_pay_time', 'order_pay_status', 'order_pay_type', 'order_status', 'created_at']);
    }

    public function goods(): HasMany
    {
        return $this->hasMany(OrderRefundGoods::class, 'refund_order_no', 'refund_order_no');
    }
}
