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

use Hyperf\Constants\Annotation\Constants;

#[Constants]
class PayTypeConstant
{
    public const PAY_TYPE_ALIPAY = 'alipay';

    public const PAY_TYPE_WECHAT = 'wechat';

    public const PAY_TYPE_WALLET = 'wallet';

    public static array $payTypeInt = [
        self::PAY_TYPE_WALLET => 1,
        self::PAY_TYPE_ALIPAY => 2,
        self::PAY_TYPE_WECHAT => 3,
    ];
}
