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

use App\System\Model\SystemDictData;
use App\System\Model\SystemDictType;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;
use Mine\Annotation\Transaction;

/**
 * Class SystemUserMapper.
 */
class SystemDictTypeMapper extends AbstractMapper
{
    /**
     * @var SystemDictType
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemDictType::class;
    }

    #[Transaction]
    public function update(int $id, array $data): bool
    {
        parent::update($id, $data);
        SystemDictData::where('type_id', $id)->update(['code' => $data['code']]) > 0;
        return true;
    }

    #[Transaction]
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $model = $this->model::withTrashed()->find($id);
            if ($model) {
                $model->dictData()->forceDelete();
                $model->forceDelete();
            }
        }
        return true;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['code'])) {
            $query->where('code', 'like', '%' . $params['code'] . '%');
        }
        if (! empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (! empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }
}
