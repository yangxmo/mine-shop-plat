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

namespace App\Goods\Request;

use Hyperf\Validation\Rule;
use Mine\MineFormRequest;

/**
 * 商品分类验证数据类.
 */
class GoodsCategoryRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    public function changeStatusRules(): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('goods_category', 'id')->whereNull('deleted_at')],
            'statusValue' => 'required',
            'statusName' => 'required'
        ];
    }

    /**
     * 新增数据验证规则
     * return array.
     */
    public function saveRules(): array
    {
        return [
            // 上级ID 验证
            'parent_id' => ['nullable', Rule::exists('goods_category', 'id')],
            // 分组名称 验证
            'title' => 'required|between:1,7',
            // 分组状态（2无用1有用） 验证
            'status' => 'required|in:1,2',
            // 分类排序 验证
            'sort' => 'required|integer|min:1|max:999',
        ];
    }

    /**
     * 更新数据验证规则
     * return array.
     */
    public function updateRules(): array
    {
        return [
            // 上级ID 验证
            'parent_id' => ['nullable', Rule::exists('goods_category', 'id')],
            // 分组名称 验证
            'title' => 'required|between:1,7',
            // 分组状态（2无用1有用） 验证
            'status' => 'required|in:1,2',
            // 分类排序 验证
            'sort' => 'required|integer|min:1|max:999',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'parent_id' => '上级分组',
            'title' => '分组名称',
            'status' => '分组状态',
            'sort' => '分类排序',
        ];
    }
}
