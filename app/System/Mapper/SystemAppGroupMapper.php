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
namespace App\System\Mapper;

use App\System\Model\SystemAppGroup;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemAppGroupMapper.
 */
class SystemAppGroupMapper extends AbstractMapper
{
    /**
     * @var SystemAppGroup
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemAppGroup::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 应用组名称
        if (! empty($params['name'])) {
            $query->where('name', '=', $params['name']);
        }

        // 状态
        if (! empty($params['status'])) {
            $query->where('status', '=', $params['status']);
        }
        return $query;
    }
}
