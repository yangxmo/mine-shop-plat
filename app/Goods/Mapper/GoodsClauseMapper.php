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

use App\Goods\Model\GoodsClause;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 商品服务Mapper类.
 */
class GoodsClauseMapper extends AbstractMapper
{
    /**
     * @var GoodsClause
     */
    public $model;

    public function assignModel()
    {
        $this->model = GoodsClause::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name']);
        }

        if (! empty($params['term']) && is_array($params['term'])) {
//            $query->whereJsonContains('term', );
        }

        if (! empty($params['sort'])) {
            $query->where('sort', '=', $params['sort']);
        }

        return $query;
    }
}
