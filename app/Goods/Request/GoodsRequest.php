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
namespace App\Goods\Request;

use Hyperf\Validation\Rule;
use Mine\MineFormRequest;

/**
 * 商品分类验证数据类.
 */
class GoodsRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 新增数据验证规则
     * return array.
     */
    public function saveRules(): array
    {
        return [
            // 商品名称 验证
            'goods_name' => ['required','between:2,50', Rule::unique('goods', 'goods_name')],
            // 商品关键词
            'goods_keyword' => 'nullable|between:1,20',
            // 分类排序 验证
            'goods_category_id' => ['required', 'integer', Rule::exists('goods_category', 'id')],
            // 产品价格
            'goods_price' => 'required|numeric|min:0.00|max:9999999',
            // 会员价格
            'goods_vip_price' => 'nullable|numeric|min:0.00|max:9999999',
            // 市场价
            'goods_market_price' => 'required|numeric|min:0.01|max:9999999',
            // 总库存
            'goods_sale' => 'required|integer|min:0|max:9999999',
            // 预警库存
            'goods_warn_sale' => 'nullable|integer|min:0|max:9999999',
            // 商品首图片 验证
            'goods_image' => 'required|string',
            // 商品图片 验证
            'goods_images' => 'required|array',
            // 商品状态(2下架1上架) 验证
            'goods_status' => 'required|integer|in:1,2',
            // 商品类型
            'goods_type' => 'required|integer|in:1,2',
            // 商品规格类型
            'goods_spec_type' => 'required|integer|in:1,2',
            // 语言（1中文2英文）
            'goods_language' => 'required|integer|in:1,2',
            // 商品详情描述，可包含图片中心的图片URL 验证
            'goods_description' => 'required_with:goods_data',

            // 商品附属信息
            'affiliate' => 'required',
            // 商品单位
            'affiliate.goods_unit' => 'required|between:1,2',
            //是否预售商品（1否2是） 验证
            'affiliate.goods_is_presell' => 'required|in:1,2|integer',
            //是否限购商品（1否2是） 验证
            'affiliate.goods_is_purchase' => 'required|in:1,2|integer',
            //限购商品类型（1单次限购2全部限购） 验证
            'affiliate.goods_purchase_type' => 'required_with:goods_is_purchase,2|integer|in:1,2',
            //限购商品数量 验证
            'affiliate.goods_purchase_num' => 'required_with:goods_is_purchase,2|integer|min:0|max:99999',
            //是否会员商品（1否2是） 验证
            'affiliate.goods_is_vip' => 'required|integer|in:1,2',
            //商品购买送积分 验证
            'affiliate.goods_buy_point' => 'required|integer|min:0|max:9999',
            //商品已售数量 验证
            'affiliate.goods_sales' => 'nullable|integer|min:0',
            //商品推荐 验证
            'affiliate.goods_recommend' => 'nullable|integer|in:1,2',
            //商品运费方式，（1固定邮费2运费模板）
            'affiliate.goods_freight_type' => 'nullable|integer|in:1,2',
            //商品物流方式
            'affiliate.goods_logistics_type' => 'nullable|integer|in:1,2',

            // 商品属性数据
            'attributes_data' => 'required_if:goods_spec_type,2|array',
            // 商品属性数据名称
            'attributes_data.*.attributes_name' => ['required_with:attributes_data', 'between:1,20'],
            // 商品属性值数据
            'attributes_data.*.value' => 'required_with:attributes_data|array',
            // 商品属性值数据
            'attributes_data.*.value.*.attr_value' => ['required_with:attributes_data', 'between:1,20'],
            // 商品sku
            'attributes_data.*.value.*.sku_data' => 'required_if:goods_spec_type,2|array',
            // 商品sku名称
            'attributes_data.*.value.*.sku_data.*.goods_sku_name' => ['required_with:attributes_data.*.value.*.sku_data', 'between:1,20'],
            // 商品sku值
            'attributes_data.*.value.*.sku_data.*.goods_sku_value' => ['required_with:attributes_data.*.value.*.sku_data', 'between:1,20'],
            // 商品sku价格
            'attributes_data.*.value.*.sku_data.*.goods_sku_price' => ['required_with:attributes_data.*.value.*.sku_data', 'numeric', 'between:0,500'],
            // 商品sku图片
            'attributes_data.*.value.*.sku_data.*.goods_sku_image' => ['required_with:attributes_data.*.value.*.sku_data', 'string', 'url'],
            // 商品sku库存
            'attributes_data.*.value.*.sku_data.*.goods_sku_sale' => ['required_with:attributes_data.*.value.*.sku_data', 'integer', 'between:0,99999'],
            // 商品市场价
            'attributes_data.*.value.*.sku_data.*.goods_sku_market_price' => ['required_with:attributes_data.*.value.*.sku_data', 'numeric', 'between:0,99999'],
        ];
    }

    /**
     * 更新数据验证规则
     * return array.
     */
    public function updateRules(): array
    {
        return [
            // 商品名称 验证
            'goods_name' => ['required','between:2,50', Rule::unique('goods', 'goods_name')->ignore($this->route('id'), 'id')],
            // 商品单位
            'affiliate.goods_unit' => 'required|between:1,2',
            // 商品关键词
            'goods_keyword' => 'nullable|between:1,20',
            // 分类排序 验证
            'goods_category_id' => ['required', 'integer', Rule::exists('goods_category', 'id')],
            // 产品价格
            'goods_price' => 'required|numeric|min:0.00|max:9999999',
            // 会员价格
            'goods_vip_price' => 'nullable|numeric|min:0.00|max:9999999',
            // 市场价
            'goods_market_price' => 'required|numeric|min:0.01|max:9999999',
            // 总库存
            'goods_sale' => 'required|integer|min:0|max:9999999',
            // 预警库存
            'goods_warn_sale' => 'nullable|integer|min:0|max:9999999',
            // 商品图片 验证
            'goods_images' => 'required|array',
            // 商品状态(2下架1上架) 验证
            'goods_status' => 'required|integer|in:1,2',
            // 商品类型
            'goods_type' => 'required|integer|in:1,2',
            // 商品规格类型
            'goods_spec_type' => 'required|integer|in:1,2',
            // 语言（1中文2英文）
            'goods_language' => 'required|integer|in:1,2',
            // 商品详情描述，可包含图片中心的图片URL 验证
            'goods_description' => 'required_with:goods_data',

            // 商品附属信息
            'affiliate' => 'required',
            //是否预售商品（1否2是） 验证
            'affiliate.goods_is_presell' => 'required|in:1,2|integer',
            //是否限购商品（1否2是） 验证
            'affiliate.goods_is_purchase' => 'required|in:1,2|integer',
            //限购商品类型（1单次限购2全部限购） 验证
            'affiliate.goods_purchase_type' => 'required_with:goods_is_purchase,2|integer|in:1,2',
            //限购商品数量 验证
            'affiliate.goods_purchase_num' => 'required_with:goods_is_purchase,2|integer|min:1|max:99999',
            //是否会员商品（1否2是） 验证
            'affiliate.goods_is_vip' => 'required|integer|in:1,2',
            //商品购买送积分 验证
            'affiliate.goods_buy_point' => 'required|integer|min:0|max:9999',
            //商品已售数量 验证
            'affiliate.goods_sales' => 'nullable|integer|min:0',
            //商品推荐 验证
            'affiliate.goods_recommend' => 'nullable|integer|in:1,2',

            // 商品属性数据
            'attributes_data' => 'nullable|array',
            // 商品属性数据no
            'attributes_data.*.attr_no' => ['nullable', 'integer'],
            // 商品属性数据名称
            'attributes_data.*.attributes_name' => ['required_with:attributes_data', 'between:1,20'],
            // 商品属性值数据
            'attributes_data.*.value' => 'required_with:attributes_data|array',
            // 商品属性值编号
            'attributes_data.*.value.*.attr_value_no' => ['nullable', 'integer'],
            // 商品属性值数据
            'attributes_data.*.value.*.attr_value' => ['required_with:attributes_data', 'between:1,20'],
            // 商品sku
            'attributes_data.*.value.*.sku_data' => 'required_if:goods_spec_type,2|array',
            // 商品sku id
            'attributes_data.*.value.*.sku_data.*.goods_sku_id' => ['nullable', 'integer'],
            // 商品sku名称
            'attributes_data.*.value.*.sku_data.*.goods_sku_name' => ['required_with:attributes_data.*.value.*.sku_data', 'between:1,20'],
            // 商品sku值
            'attributes_data.*.value.*.sku_data.*.goods_sku_value' => ['required_with:attributes_data.*.value.*.sku_data', 'between:1,20'],
            // 商品sku价格
            'attributes_data.*.value.*.sku_data.*.goods_sku_price' => ['required_with:attributes_data.*.value.*.sku_data', 'numeric', 'between:0,500'],
            // 商品sku图片
            'attributes_data.*.value.*.sku_data.*.goods_sku_image' => ['required_with:attributes_data.*.value.*.sku_data', 'string', 'url'],
            // 商品sku库存
            'attributes_data.*.value.*.sku_data.*.goods_sku_sale' => ['required_with:attributes_data.*.value.*.sku_data', 'integer', 'between:0,99999'],
            // 商品市场价
            'attributes_data.*.value.*.sku_data.*.goods_sku_market_price' => ['required_with:attributes_data.*.value.*.sku_data', 'numeric', 'between:0,99999'],
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            // 商品名称
            'goods_name' => '商品名称',
            // 商品类型
            'goods_type' => '商品类型',
            // 商品单位
            'affiliate.goods_unit' => '商品单位名称',
            // 分类排序 验证
            'goods_category_id' => '商品分类',
            // 产品价格
            'goods_price' => '商品价格',
            // 市场价
            'goods_market_price' => '市场价',
            // 总库存
            'goods_sale' => '商品库存',
            // 图片
            'goods_images' => '商品图片',
            // 视频
            'goods_video' => '商品视频',
            // 商品状态（1上架2下架）
            'goods_status' => '商品状态',
            // 语言（1中文2英文）
            'goods_language' => '商品语言',
            // 说明
            'goods_description' => '商品说明',

            //是否预售商品（1否2是） 验证
            'affiliate.goods_is_presell' => '是否预售商品',
            //是否限购商品（1否2是） 验证
            'affiliate.goods_is_purchase' => '是否限购商品',
            //限购商品类型（1单次限购2全部限购） 验证
            'affiliate.goods_purchase_type' => '限购商品类型',
            //限购商品数量 验证
            'affiliate.goods_purchase_num' => '限购商品数量',
            //是否会员商品（1否2是） 验证
            'affiliate.goods_is_vip' => '是否会员商品',
            //商品购买送积分 验证
            'affiliate.goods_buy_point' => '商品购买送积分',
            //商品已售数量 验证
            'affiliate.goods_sales' => '商品已售数量',
            //商品推荐 验证
            'affiliate.goods_recommend' => '商品推荐',

            // 商品属性数据
            'attributes_data' => '商品属性',
            // 商品属性数据数组
            'attributes_data.*.attributes_no' => '商品属性ID',
            // 商品属性分类ID
            'attributes_data.*.goods_category_id' => '商品分类ID',
            // 商品属性数据名称
            'attributes_data.*.attributes_name' => '商品属性名称',
            // 商品属性值数据
            'attributes_data.*.value' => '商品属性值',
            // 商品属性值数据编号
            'attributes_data.*.value.*.attr_no' => '商品属性值编号',
            // 商品属性值数据
            'attributes_value_data.*.value.*.attr_value' => '商品属性值数据',
            // 商品sku
            'attributes_value_data.*.value.*.sku_data' => '商品规格数据',
            // 商品skuID
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_id' => '商品规格ID',
            // 商品sku名称
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_name' => '商品规格名称',
            // 商品sku值
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_value' => '商品规格值',
            // 商品sku排序
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_sort' => '商品规格排序',
            // 商品sku价格
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_price' => '商品规格价格',
            // 商品sku图片
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_image' => '商品规格图片',
            // 商品sku库存
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_sale' => '商品规格库存',
            // 商品市场价
            'attributes_value_data.*.value.*.sku_data.*.goods_sku_market_price' => '商品规格市场价',
        ];
    }
}
