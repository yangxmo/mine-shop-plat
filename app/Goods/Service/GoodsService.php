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

use App\Goods\Assemble\AssembleGoodsData;
use App\Goods\Mapper\GoodsMapper;
use Hyperf\Collection\Arr;
use Mine\Abstracts\AbstractService;

/**
 * 商品分类服务类.
 */
class GoodsService extends AbstractService
{
    /**
     * @var GoodsMapper
     */
    public $mapper;

    public function __construct(GoodsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 保存商品
     */
    public function save(array $data): int
    {
        $skuData = [];
        // build 商品规格属性
        $data['attributes_data'] = AssembleGoodsData::buildGoodsAttribute($data, $skuData);
        // build 商品附属属性
        $data['affiliate_data'] = AssembleGoodsData::buildGoodsAffiliate($data['affiliate']);
        // build 属性值
        $data['attributes_value'] = Arr::collapse(array_column($data['attributes_data'], 'value'));
        // build sku数据
        $data['sku_data'] = $skuData;

        return $this->mapper->save($data);
    }

    /**
     * 修改商品
     */
    public function update(int $id, array $data): bool
    {
        $skuData = [];
        // build 属性
        $data['attributes_data'] = AssembleGoodsData::buildUpdateGoodsAttribute($data, $skuData);
        // build 商品附属属性
        $data['affiliate_data'] = AssembleGoodsData::buildGoodsAffiliate($data['affiliate']);
        // build 属性值
        $data['attributes_value'] = Arr::collapse(array_column($data['attributes_data'], 'value'));
        // build sku数据
        $data['sku_data'] = $skuData;

        return $this->mapper->update($id, $data);
    }
}
