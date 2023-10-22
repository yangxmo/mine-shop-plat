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
namespace App\Goods\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class GoodsConstants extends AbstractConstants
{
    // 使用中
    public const GOODS_STATUS_USE = 1;
    // 不使用
    public const GOODS_STATUS_USE_FAIL = 2;
    // 不预售
    public const GOODS_PRESELL_NO = 1;
    // 预售
    public const GOODS_PRESELL_YES = 2;
    // 不限购
    public const GOODS_PURCHASE_NO = 1;
    // 限购
    public const GOODS_PURCHASE_YES = 2;
    // 非会员产品
    public const GOODS_VIP_NO = 1;
    // 会员产品
    public const GOODS_VIP_YES = 2;
    // 物流方式
    public const GOODS_LOGISTICS = 1;
    // 门店核销
    public const GOODS_VERIFICATION = 2;
    // 库存不足
    public const GOODS_STATUS_STOCK_FAIL = 4;
}
