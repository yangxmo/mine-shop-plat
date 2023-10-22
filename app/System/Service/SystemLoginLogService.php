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

use App\System\Mapper\SystemLoginLogMapper;
use Mine\Abstracts\AbstractService;

/**
 * 登录日志业务
 * Class SystemLoginLogService.
 */
class SystemLoginLogService extends AbstractService
{
    /**
     * @var SystemLoginLogMapper
     */
    public $mapper;

    public function __construct(SystemLoginLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
