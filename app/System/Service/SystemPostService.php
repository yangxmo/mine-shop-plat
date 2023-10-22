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

use App\System\Mapper\SystemPostMapper;
use Mine\Abstracts\AbstractService;

class SystemPostService extends AbstractService
{
    /**
     * @var SystemPostMapper
     */
    public $mapper;

    public function __construct(SystemPostMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
