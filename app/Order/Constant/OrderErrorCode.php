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
 * 订单异常.
 */
#[Constants]
class OrderErrorCode extends AbstractConstants
{
    public const ORDER_NOT_PAY_ERROR = 20000;

    public const ORDER_REFUND_RUNNING = 20001;

    public const ORDER_REFUND_ERROR = 20002;
}
