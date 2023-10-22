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
 * 订单状态（1正常2用户取消3系统取消4待发货5待收货6订单完成）.
 */
#[Constants]
class OrderStatusCode extends AbstractConstants
{
    # #####################################################订单状态######################################################

    public const ORDER_STATUS_TRUE = 1;

    public const ORDER_STATUS_CANCEL = 2;

    public const ORDER_STATUS_SYSTEM_CANCEL = 3;

    public const ORDER_STATUS_PROCESSED = 4;

    public const ORDER_STATUS_SHIPPED = 5;

    public const ORDER_STATUS_SUCCESS = 6;

    public const ORDER_STATUS_SELLER_CANCEL = 7;

    public const ORDER_STATUS_OTHER_CANCEL = 8;

    # #####################################################基础订单退款状态######################################################
    // 未退款
    public const ORDER_BASE_REFUND_STATUS_NO_REFUND = 1;

    // 审核中
    public const ORDER_BASE_REFUND_AUDIT_RUNNING = 2;

    // 审核成功退款中
    public const ORDER_BASE_REFUND_AUDIT_SUCCESS = 3;

    // 审核失败
    public const ORDER_BASE_REFUND_AUDIT_FAIL = 4;

    // 部分退款成功
    public const ORDER_BASE_REFUND_SECTION = 5;

    // 全部退款成功
    public const ORDER_BASE_REFUND_STATUS_ALL = 6;

    # #####################################################售后订单状态######################################################

    // 待审核
    public const ORDER_REFUND_STATUS_STAY_AUDIT = 1;

    // 审核通过
    public const ORDER_REFUND_STATUS_AUDIT_PASS = 2;

    // 审核拒绝
    public const ORDER_REFUND_STATUS_AUDIT_REFUSE = 3;
}
