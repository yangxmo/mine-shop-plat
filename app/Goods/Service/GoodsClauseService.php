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
namespace App\Goods\Service;

use App\Goods\Mapper\GoodsClauseMapper;
use Mine\Abstracts\AbstractService;

/**
 * 商品服务类.
 */
class GoodsClauseService extends AbstractService
{
    /**
     * @var GoodsClauseMapper
     */
    public $mapper;

    public function __construct(GoodsClauseMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
