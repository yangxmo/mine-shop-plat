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

use App\Users\Model\UsersOpenPlatForm;
use Mine\Abstracts\AbstractMapper;

class UserPlatFormMapper extends AbstractMapper
{
    public $model;

    public function assignModel(): void
    {
        $this->model = UsersOpenPlatForm::class;
    }

    /**
     * 获取或创建用户信息.
     */
    public function getOrNewUserByWx(array $params): mixed
    {
        return $this->model::updateOrCreate(['open_id' => $params['open_id']], $params);
    }
}
