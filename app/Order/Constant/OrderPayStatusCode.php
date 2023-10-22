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
namespace App\Order\Constant;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 订单支付状态（1待支付2支付成功）.
 */
#[Constants]
class OrderPayStatusCode extends AbstractConstants
{
    public const PAY_STATUS_SUCCESS = 2;

    public const PAY_STATUS_FAIL = 1;

    // 支付宝回调状态
    public static array $payStatus = [
        'TRADE_SUCCESS' => self::PAY_STATUS_SUCCESS,
        'TRADE_FINISHED' => self::PAY_STATUS_SUCCESS,
        'TRADE_CLOSED' => self::PAY_STATUS_FAIL,
        'WAIT_BUYER_PAY' => self::PAY_STATUS_FAIL,
    ];
}
