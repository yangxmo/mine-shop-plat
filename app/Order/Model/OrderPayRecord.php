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
 * @property string $trade_no
 * @property string $pay_trade_no
 * @property string $plat_pay_trade_no
 * @property float $pay_price
 * @property int $pay_type
 * @property int $pay_status
 * @property int $plat_pay_status
 * @property string $pay_params
 * @property string $pay_callback_params
 * @property int $created_at
 * @property int $updated_at
 */
class OrderPayRecord extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'order_pay_record';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['order_no', 'trade_no', 'pay_trade_no', 'plat_pay_trade_no', 'pay_price', 'pay_type', 'pay_status', 'plat_pay_status', 'pay_params', 'pay_callback_params', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['order_no' => 'string', 'pay_trade_no' => 'string', 'pay_price' => 'float', 'pay_type' => 'integer', 'plat_pay_status' => 'integer', 'pay_status' => 'integer'];
}
