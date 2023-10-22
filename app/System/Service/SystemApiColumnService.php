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

use App\System\Mapper\SystemApiColumnMapper;
use Mine\Abstracts\AbstractService;

/**
 * api接口字段业务
 * Class SystemApiColumnService.
 */
class SystemApiColumnService extends AbstractService
{
    /**
     * @var SystemApiColumnMapper
     */
    public $mapper;

    public function __construct(SystemApiColumnMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
