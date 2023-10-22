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

namespace App\Users\Mapper;

use App\Users\Model\UsersBalanceLog;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 表注释Mapper类.
 */
class UsersBalanceLogMapper extends AbstractMapper
{
    /**
     * @var UsersBalanceLog
     */
    public $model;

    public function assignModel()
    {
        $this->model = UsersBalanceLog::class;
    }

    /**
     * 分页.
     */
    public function getPageList(?array $params, bool $isScope = true, string $pageName = 'page'): array
    {
        $params['select'] = UsersBalanceLog::$selectField;

        $query = $this->listQuerySetting($params, $isScope);

        $this->handleUserSearch($query, $params);

        $paginate = $query->with(['userInfo'])->paginate(
            (int) $params['pageSize'] ?? $this->model::PAGE_SIZE,
            ['*'],
            $pageName,
            (int) $params[$pageName] ?? 1
        );

        return $this->setPaginate($paginate, $params);
    }

    /*
     * 用户信息检测
     */
    public function handleUserSearch(Builder $query, $params)
    {
        if (! empty($params['user_info_nickname'])) {
            $query = $query->has('userInfo', '>=', 1, 'and', function ($query) use ($params) {
                $query->where('nickname', 'like', '%' . $params['user_info_nickname']);
            });
        }

        return $query;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 用户ID
        if (! empty($params['user_id'])) {
            $query->where('user_id', '=', $params['user_id']);
        }

        // 交易类型(1:充值,2:提现,3:转账,4:退款,5:扣款,6:系统)
        if (! empty($params['type'])) {
            $query->where('type', '=', $params['type']);
        }

        // 交易状态(1:成功,2:失败,3:处理中
        if (! empty($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        // 交易前余额
        if (! empty($params['before_balance'])) {
            $query->where('before_balance', '=', $params['before_balance']);
        }

        // 交易后余额
        if (! empty($params['after_balance'])) {
            $query->where('after_balance', '=', $params['after_balance']);
        }

        return $query;
    }
}
