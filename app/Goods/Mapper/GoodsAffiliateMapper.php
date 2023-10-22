<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\Goods\Mapper;

use App\Goods\Model\GoodsAffiliate;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 商品附属信息Mapper类
 */
class GoodsAffiliateMapper extends AbstractMapper
{
    /**
     * @var GoodsAffiliate
     */
    public $model;

    public function assignModel()
    {
        $this->model = GoodsAffiliate::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {

        // 是否预售商品（1否2是）
        if (!empty($params['goods_is_presell'])) {
            $query->where('goods_is_presell', '=', $params['goods_is_presell']);
        }

        // 是否限购商品（1否2是）
        if (!empty($params['goods_is_purchase'])) {
            $query->where('goods_is_purchase', '=', $params['goods_is_purchase']);
        }

        // 是否会员商品（1否2是）
        if (!empty($params['goods_is_vip'])) {
            $query->where('goods_is_vip', '=', $params['goods_is_vip']);
        }

        // 商品物流方式，（1物流2到店核销）
        if (!empty($params['goods_logistics_type'])) {
            $query->where('goods_logistics_type', '=', $params['goods_logistics_type']);
        }

        return $query;
    }
}