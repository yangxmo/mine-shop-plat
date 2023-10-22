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

use App\System\Model\SystemApiLog;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemApiMapper.
 */
class SystemApiLogMapper extends AbstractMapper
{
    /**
     * @var SystemApiLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemApiLog::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['api_name'])) {
            $query->where('api_name', 'like', '%' . $params['api_name'] . '%');
        }
        if (! empty($params['ip'])) {
            $query->where('ip', 'like', '%' . $params['ip'] . '%');
        }
        if (! empty($params['access_name'])) {
            $query->where('access_name', 'like', '%' . $params['access_name'] . '%');
        }
        if (! empty($params['access_time']) && is_array($params['access_time']) && count($params['access_time']) == 2) {
            $query->whereBetween(
                'access_time',
                [$params['access_time'][0] . ' 00:00:00', $params['access_time'][1] . ' 23:59:59']
            );
        }
        return $query;
    }
}
