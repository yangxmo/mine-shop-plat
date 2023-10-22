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
namespace App\Order\Request;

use Mine\MineApiFormRequest;

/**
 * 商品购物车验证数据类.
 */
class OrderPreviewRequest extends MineApiFormRequest
{
    /**
     * 获取订单确认页面数据验证规则
     * return array.
     */
    public function getOrderPreviewRules(): array
    {
        return [
            'goods' => 'required|array',
            // 商品ID 验证
            'goods.*.goods_id' => 'required|integer',
            // 商品skuID
            'goods.*.goods_sku_id' => 'nullable|integer',
            // 商品数量 验证
            'goods.*.goods_num' => 'required|integer|min:1',
            // 地址
            'address' => 'required|array',
            'address.province_name' => 'required|string',
            'address.province_code' => 'required|integer',
            'address.city_code' => 'nullable|integer',
            'address.city_name' => 'required|string',
            'address.area_name' => 'required|string',
            'address.area_code' => 'nullable|integer',
            'address.street_name' => 'required|string',
            'address.street_code' => 'required|integer',
            'address.description' => 'required|string',
            'address.mobile' => 'required|numeric',
            'address.username' => 'required|string',
            // 是否购物车
            'is_cart' => 'required|boolean',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'title' => '分组名称',
            'status' => '分组状态（0无用1有用）',
            'sort' => '分类排序',
        ];
    }
}
