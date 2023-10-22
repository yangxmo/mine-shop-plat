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

use App\System\Model\SystemApp;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\AbstractMapper;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class SystemAppMapper.
 */
class SystemAppMapper extends AbstractMapper
{
    /**
     * @var SystemApp
     */
    public $model;

    public function assignModel()
    {
        $this->model = SystemApp::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['app_name'])) {
            $query->where('app_name', $params['app_name']);
        }

        if (! empty($params['app_id'])) {
            $query->where('app_id', $params['app_id']);
        }

        if (! empty($params['group_id'])) {
            $query->where('group_id', $params['group_id']);
        }

        if (! empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }

    /**
     * 绑定接口.
     */
    public function bind(int $id, array $ids): bool
    {
        $model = $this->read($id);
        $model && $model->apis()->sync($ids);
        return true;
    }

    /**
     * 获取api列表.
     */
    public function getApiList(int $appId): array
    {
        return Db::table('system_app_api')->where('app_id', $appId)->pluck('api_id')->toArray();
    }

    /**
     * 通过app_id获取app信息和接口数据.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAppAndInterfaceList(string $appId): array
    {
        $data = $this->model::query()->where('app_id', $appId)
            ->with(['apis' => function ($query) {
                $query->where('status', SystemApp::ENABLE);
            }])->first(['id', 'app_id', 'app_secret', 'app_name', 'updated_at', 'description'])->toArray();

        $groupIds = [];
        foreach ($data['apis'] as $api) {
            $groupIds[] = $api['group_id'];
        }
        $systemApiGroupMapper = container()->get(\App\System\Mapper\SystemApiGroupMapper::class);
        $data['apiGroup'] = $systemApiGroupMapper->get(function ($query) use ($groupIds) {
            /* @var Hyperf\Database\Model\Builder $query */
            return $query->whereIn('id', array_unique($groupIds));
        }, ['id', 'name']);

        return $data;
    }
}
