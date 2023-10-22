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
 * @property string $refund_user_name
 * @property string $refund_user_mobile
 * @property string $refund_user_address
 * @property string $refund_user_logistics_no
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderRefundAddress extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_refund_address';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['refund_order_no', 'refund_user_name', 'refund_user_mobile', 'refund_user_address', 'refund_user_logistics_no', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['refund_order_no' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
