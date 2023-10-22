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

use App\System\Model\SystemLoginLog;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemUserMapper.
 */
class SystemLoginLogMapper extends AbstractMapper
{
    /**
     * @var SystemLoginLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemLoginLog::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['ip'])) {
            $query->where('ip', $params['ip']);
        }

        if (! empty($params['username'])) {
            $query->where('username', 'like', '%' . $params['username'] . '%');
        }

        if (! empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (! empty($params['login_time']) && is_array($params['login_time']) && count($params['login_time']) == 2) {
            $query->whereBetween(
                'login_time',
                [$params['login_time'][0] . ' 00:00:00', $params['login_time'][1] . ' 23:59:59']
            );
        }
        return $query;
    }
}
