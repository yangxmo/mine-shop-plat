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
namespace App\System\Service;

use App\System\Mapper\SystemAppGroupMapper;
use App\System\Model\SystemAppGroup;
use Mine\Abstracts\AbstractService;

/**
 * app应用分组业务
 * Class SystemAppGroupService.
 */
class SystemAppGroupService extends AbstractService
{
    /**
     * @var SystemAppGroupMapper
     */
    public $mapper;

    public function __construct(SystemAppGroupMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 获取分组列表 无分页.
     */
    public function getList(?array $params = null, bool $isScope = true): array
    {
        return $this->mapper->getList(['select' => ['id', 'name'], 'status' => SystemAppGroup::ENABLE], $isScope);
    }
}
