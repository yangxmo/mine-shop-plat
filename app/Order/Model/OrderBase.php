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

use App\Users\Model\UsersUser;
use Hyperf\Database\Model\Relations\belongsTo;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\Relations\HasOne;
use Mine\MineModel;

/**
 * @property int $id
 * @property int $order_no
 * @property string $order_price
 * @property string $order_discount_price
 * @property string $order_freight_price
 * @property string $order_pay_price
 * @property string $order_pay_time
 * @property string $order_cancel_time
 * @property string $tenant_id
 * @property int $order_create_user_id
 * @property int $order_status
 * @property int $order_pay_status
 * @property int $order_refund_status
 * @property int $order_pay_type
 * @property string $order_remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderBase extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_base';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'order_no', 'order_price', 'order_discount_price', 'order_freight_price', 'order_pay_price', 'order_pay_time', 'order_cancel_time', 'tenant_id', 'order_create_user_id', 'order_status', 'order_pay_status', 'order_refund_status', 'order_pay_type', 'order_remark', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'int', 'order_no' => 'int', 'order_price' => 'decimal:2', 'order_discount_price' => 'decimal:2', 'order_freight_price' => 'decimal:2', 'order_pay_price' => 'decimal:2', 'order_create_user_id' => 'integer', 'order_status' => 'int', 'order_pay_status' => 'int', 'order_refund_status' => 'int', 'order_pay_type' => 'int', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function address(): HasOne
    {
        return $this->hasOne(OrderAddress::class, 'order_no', 'order_no');
    }

    public function goods(): HasMany
    {
        return $this->hasMany(OrderGoods::class, 'order_no', 'order_no');
    }

    public function payRecord(): HasOne
    {
        return $this->hasOne(OrderPayRecord::class, 'order_no', 'order_no');
    }

    public function orderActionRecord(): HasMany
    {
        return $this->hasMany(OrderActionRecord::class, 'order_no', 'order_no');
    }

    /**
     * 定义 userInfo 关联.
     */
    public function userInfo(): belongsTo
    {
        return $this->belongsTo(UsersUser::class, 'order_create_user_id', 'id');
    }
}
