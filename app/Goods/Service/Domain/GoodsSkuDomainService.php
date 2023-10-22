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

use App\Goods\Mapper\GoodsSkuMapper;
use Mine\Abstracts\AbstractService;

/**
 * 商品sku服务类.
 */
class GoodsSkuDomainService extends AbstractService
{
    /**
     * @var GoodsSkuMapper
     */
    public $mapper;

    public function __construct(GoodsSkuMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
