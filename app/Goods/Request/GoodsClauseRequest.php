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
 * 商品服务验证数据类.
 */
class GoodsClauseRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 新增数据验证规则
     * return array.
     */
    public function saveRules(): array
    {
        return [
            // 服务名称 验证
            'name' => ['required', 'between:1,15'],
            // 服务条款 验证
            'term' => 'required|array',
            // 服务排序 验证
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
            // 服务名称 验证
            'name' => ['required', 'between:1,15'],
            // 服务条款 验证
            'term' => 'required|array',
            // 服务排序 验证
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
            'name' => '商品服务名称',
            'term' => '商品服务条款',
            'sort' => '商品服务排序',
        ];
    }
}
