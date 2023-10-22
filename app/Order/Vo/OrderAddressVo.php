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
namespace App\Order\Vo;

class OrderAddressVo
{
    // 省编码
    public string $provinceCode = '';

    // 省名称
    public string $provinceName = '';

    // 市编码
    public int $cityCode = 0;

    // 市名称
    public string $cityName = '';

    // 区编码
    public int $areaCode = 0;

    // 区名称
    public string $areaName = '';

    // 街道名称
    public string $streetName = '';

    // 街道code
    public int $streetCode = 0;

    // 详细地址
    public string $description = '';

    // 商品购买数量
    public int $num = 0;

    // 第三方产品信息
    public array $productInfo = [];

    // 用户名称
    public string $userName = '';

    // 用户手机号
    public int $userPhone = 0;

    // 邮政编码
    public int $postCode = 0;
}
