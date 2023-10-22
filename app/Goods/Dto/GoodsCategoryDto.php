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
 * 商品分类Dto （导入导出）.
 */
#[ExcelData]
class GoodsCategoryDto implements MineModelExcel
{
    #[ExcelProperty(value: 'id', index: 0)]
    public string $id;

    #[ExcelProperty(value: '上级ID', index: 1)]
    public string $parent_id;

    #[ExcelProperty(value: '分组名称', index: 2)]
    public string $title;

    #[ExcelProperty(value: '分组下商品总数', index: 3)]
    public string $feed_count;

    #[ExcelProperty(value: '分组状态（2无用1有用）', index: 4)]
    public string $status;

    #[ExcelProperty(value: '分类排序', index: 5)]
    public string $sort;

    #[ExcelProperty(value: 'created_at', index: 6)]
    public string $created_at;

    #[ExcelProperty(value: 'updated_at', index: 7)]
    public string $updated_at;

    #[ExcelProperty(value: 'deleted_at', index: 8)]
    public string $deleted_at;
}
