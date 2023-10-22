<?php
namespace App\Goods\Dto;

use Mine\Interfaces\MineModelExcel;
use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;

/**
 * 商品属性表Dto （导入导出）
 */
#[ExcelData]
class GoodsAttributesDto implements MineModelExcel
{
    #[ExcelProperty(value: "id", index: 0)]
    public string $id;

    #[ExcelProperty(value: "商品编号", index: 1)]
    public string $goods_no;

    #[ExcelProperty(value: "商品属性编号", index: 2)]
    public string $attr_no;

    #[ExcelProperty(value: "商品属性名", index: 3)]
    public string $attributes_name;


}