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

use App\Setting\Model\SettingConfigGroup;
use Exception;
use Mine\Abstracts\AbstractMapper;

class SettingConfigGroupMapper extends AbstractMapper
{
    /**
     * @var SettingConfigGroup
     */
    public $model;

    public function assignModel()
    {
        $this->model = SettingConfigGroup::class;
    }

    /**
     * 删除组和所属配置.
     * @throws Exception
     */
    public function deleteGroupAndConfig(int $id): bool
    {
        /* @var $model SettingConfigGroup */
        $model = $this->read($id);
        $model->configs()->delete();
        return $model->delete();
    }
}
