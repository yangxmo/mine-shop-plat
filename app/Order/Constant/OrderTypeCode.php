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
 * 订单类型（1阿里巴巴2聚合）.
 */
#[Constants]
class OrderTypeCode extends AbstractConstants
{
    public const ORDER_TYPE_ALIBABA = 1;

    public const ORDER_TYPE_AGGREGATION = 2;
}
