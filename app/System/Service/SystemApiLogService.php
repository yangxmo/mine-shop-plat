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

use App\System\Mapper\SystemApiLogMapper;
use Mine\Abstracts\AbstractService;

/**
 * api日志业务
 * Class SystemAppService.
 */
class SystemApiLogService extends AbstractService
{
    /**
     * @var SystemApiLogMapper
     */
    public $mapper;

    public function __construct(SystemApiLogMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
