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
namespace App\Setting\Mapper;

use App\Setting\Model\SettingGenerateTables;
use Exception;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;
use Mine\Annotation\Transaction;

/**
 * 生成业务信息表查询类
 * Class SettingGenerateTablesMapper.
 */
class SettingGenerateTablesMapper extends AbstractMapper
{
    /**
     * @var SettingGenerateTables
     */
    public $model;

    public function assignModel()
    {
        $this->model = SettingGenerateTables::class;
    }

    /**
     * 删除业务信息表和字段信息表.
     * @throws Exception
     */
    #[Transaction]
    public function delete(array $ids): bool
    {
        /* @var SettingGenerateTables $model */
        foreach ($this->model::query()->whereIn('id', $ids)->get() as $model) {
            if ($model) {
                $model->columns()->delete();
                $model->delete();
            }
        }
        return true;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['table_name'])) {
            $query->where('table_name', 'like', '%' . $params['table_name'] . '%');
        }
        if (! empty($params['minDate']) && ! empty($params['maxDate'])) {
            $query->whereBetween(
                'created_at',
                [$params['minDate'] . ' 00:00:00', $params['maxDate'] . ' 23:59:59']
            );
        }
        return $query;
    }
}
