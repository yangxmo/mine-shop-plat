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

use App\System\Mapper\SystemDictTypeMapper;
use Mine\Abstracts\AbstractService;

/**
 * 字典类型业务
 * Class SystemLoginLogService.
 */
class SystemDictTypeService extends AbstractService
{
    /**
     * @var SystemDictTypeMapper
     */
    public $mapper;

    public function __construct(SystemDictTypeMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
