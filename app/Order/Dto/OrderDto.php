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
namespace App\Order\Dto;

use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;
use Mine\Interfaces\MineModelExcel;

/**
 * 订单DTO.
 */
#[ExcelData]
class OrderDto implements MineModelExcel
{
    #[ExcelProperty(value: '订单编号', index: 0)]
    public string $order_no;

    #[ExcelProperty(value: '商品名称', index: 1)]
    public string $product_name;

    #[ExcelProperty(value: 'SKU名称', index: 2)]
    public string $product_sku_name;

    #[ExcelProperty(value: 'SKU值', index: 3)]
    public string $product_sku_value;

    #[ExcelProperty(value: '订单总金额', index: 4)]
    public string $order_price;

    // 1正常2用户取消3系统取消4待发货5待收货6订单完成7卖家取消8运营商取消
    #[ExcelProperty(value: '订单状态', index: 5, dictData: [1 => '待付款', 2 => '已取消', 3 => '已取消', 4 => '待发货', 5 => '待收货', 6 => '已完成', 7 => '已取消', 8 => '已取消'])]
    public string $order_status;

    #[ExcelProperty(value: '收货人名称', index: 6)]
    public string $receive_user_name;

    #[ExcelProperty(value: '收货人电话', index: 7)]
    public string $receive_user_mobile;

    #[ExcelProperty(value: '创建时间', index: 8)]
    public string $created_at;
}
