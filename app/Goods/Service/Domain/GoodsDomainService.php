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
namespace App\Goods\Service\Domain;

use App\Goods\Mapper\GoodsMapper;
use Mine\Abstracts\AbstractService;

/**
 * 商品分类服务类.
 */
class GoodsDomainService extends AbstractService
{
    /**
     * @var GoodsMapper
     */
    public $mapper;

    public function __construct(GoodsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

}
