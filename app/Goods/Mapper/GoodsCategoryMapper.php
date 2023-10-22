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
namespace App\Goods\Mapper;

use App\Goods\Model\GoodsCategory;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 商品分类Mapper类.
 */
class GoodsCategoryMapper extends AbstractMapper
{
    /**
     * @var GoodsCategory
     */
    public $model;

    public function assignModel()
    {
        $this->model = GoodsCategory::class;
    }

    /**
     * 获取前端选择树.
     */
    public function getSelectTree(): array
    {
        return $this->model::query()
            ->select(['id', 'parent_id', 'id AS value', 'title AS label'])
            ->get()->toTree();
    }

    /**
     * 查询树名称.
     */
    public function getTreeName(array $ids = null): array
    {
        return $this->model::withTrashed()->whereIn('id', $ids)->pluck('title')->toArray();
    }

    public function checkChildrenExists(int $id): bool
    {
        return $this->model::withTrashed()->where('parent_id', $id)->exists();
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 上级ID
        if (! empty($params['parent_id'])) {
            $query->where('parent_id', '=', $params['parent_id']);
        }

        // 分组名称
        if (! empty($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }

        // 分组状态（2无用1有用）
        if (! empty($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        // 分类排序
        if (! empty($params['sort'])) {
            $query->where('sort', '=', $params['sort']);
        }

        return $query;
    }
}
