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
 * @property string $receive_user_name
 * @property string $receive_user_mobile
 * @property string $receive_user_province
 * @property string $receive_user_province_code
 * @property string $receive_user_city
 * @property string $receive_user_city_code
 * @property string $receive_user_street
 * @property string $receive_user_street_code
 * @property string $receive_user_address
 * @property string $receive_logistics_type
 * @property string $receive_logistics_no
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class OrderAddress extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_address';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_no', 'receive_user_name', 'receive_user_mobile', 'receive_user_province', 'receive_user_province_code', 'receive_user_city', 'receive_user_city_code', 'receive_user_street', 'receive_user_street_code', 'receive_user_address', 'receive_logistics_type', 'receive_logistics_no', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_no' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
