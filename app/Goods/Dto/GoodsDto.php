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
namespace App\Goods\Dto;

use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;
use Mine\Interfaces\MineModelExcel;

/**
 * 商品表Dto （导入导出）.
 */
#[ExcelData]
class GoodsDto implements MineModelExcel
{
    #[ExcelProperty(value: 'id', index: 0)]
    public string $id;

    #[ExcelProperty(value: '商品唯一标识', index: 1)]
    public string $goods_no;

    #[ExcelProperty(value: '商品名称', index: 2)]
    public string $goods_name;

    #[ExcelProperty(value: '商品建议销售价', index: 3)]
    public string $goods_price;

    #[ExcelProperty(value: '参考价格，返回价格区间，可能为空', index: 4)]
    public string $goods_market_price;

    #[ExcelProperty(value: '商品库存', index: 5)]
    public string $goods_sale;

    #[ExcelProperty(value: '商品图片', index: 6)]
    public string $goods_images;

    #[ExcelProperty(value: '商品视频', index: 7)]
    public string $goods_video;

    #[ExcelProperty(value: '分组ID', index: 8)]
    public string $goods_category_id;

    #[ExcelProperty(value: '商品状态(1上架2下架)', index: 9)]
    public string $goods_status;

    #[ExcelProperty(value: '商品语言（1中文2英文）', index: 10)]
    public string $goods_language;

    #[ExcelProperty(value: '商品详情描述，可包含图片中心的图片URL', index: 11)]
    public string $goods_description;

    #[ExcelProperty(value: 'created_at', index: 12)]
    public string $created_at;

    #[ExcelProperty(value: 'updated_at', index: 13)]
    public string $updated_at;

    #[ExcelProperty(value: 'deleted_at', index: 14)]
    public string $deleted_at;
}
