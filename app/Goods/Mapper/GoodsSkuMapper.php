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
namespace App\Goods\Mapper;

use App\Goods\Model\GoodsSku;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Mine\Abstracts\AbstractMapper;
use Mine\MineModel;

/**
 * 商品属性Mapper类.
 */
class GoodsSkuMapper extends AbstractMapper
{
    /**
     * @var GoodsSku
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = GoodsSku::class;
    }

    /**
     * 商品规格详情.
     */
    #[Cacheable(prefix: 'goodsSku', value: '#{id}', group: 'goods')]
    public function read(int $id, array $column = ['*']): ?MineModel
    {
        return parent::read($id, $column);
    }

    /**
     * 清理缓存.
     */
    #[CacheEvict(prefix: 'goodsSku', value: '#{skuId}', group: 'goods')]
    public function updateOrDelete(int $skuId)
    {
    }
}
