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
namespace App\Order\Assemble;

use App\Order\Vo\OrderServiceVo;
use Carbon\Carbon;

class OrderAssemble
{
    /**
     * 构建订单数据.
     * @param OrderServiceVo $vo 订单服务对象
     */
    public static function buildOrderData(OrderServiceVo $vo): array
    {
        return [
            'order_no' => $vo->getOrderNo(),
            'order_price' => $vo->getOrderPrice(),
            'order_discount_price' => $vo->getOrderDiscountPrice(),
            'order_freight_price' => $vo->getOrderFreightPrice(),
            'order_pay_price' => $vo->getOrderPayPrice(),
            'order_remark' => '',
            'order_create_user_id' => $vo->getUserId(),
        ];
    }

    /**
     * 构建订单地址
     * @param OrderServiceVo $vo 订单服务对象
     * @return array
     */
    public static function buildOrderAddressData(OrderServiceVo $vo): array
    {
        return [
            'order_no' => $vo->getOrderNo(),
            'receive_user_name' => $vo->orderFreightVo->userName,
            'receive_user_mobile' => $vo->orderFreightVo->userPhone,
            'receive_user_province' => $vo->orderFreightVo->provinceName,
            'receive_user_province_code' => $vo->orderFreightVo->provinceCode,
            'receive_user_city' => $vo->orderFreightVo->cityName,
            'receive_user_city_code' => $vo->orderFreightVo->cityCode,
            'receive_user_street' => $vo->orderFreightVo->streetName,
            'receive_user_street_code' => '',
            'receive_user_address' => $vo->orderFreightVo->description,
        ];
    }

    /**
     * 构建订单产品数据.
     * @param OrderServiceVo $vo 订单服务对象
     */
    public static function buildOrderProductData(OrderServiceVo $vo): array
    {
        $productData = [];
        foreach ($vo->getGoodsData() as $datum) {
            $productData[] = [
                'order_no' => $vo->getOrderNo(),
                'goods_name' => $datum['goods_name'],
                'goods_sku_name' => $datum['goods_sku_name'],
                'goods_sku_value' => $datum['goods_sku_value'],
                'goods_image' => $datum['goods_image'],
                'goods_id' => $datum['goods_id'],
                'goods_sku_id' => $datum['goods_sku_id'],
                'goods_num' => $datum['goods_num'],
                'goods_price' => $datum['goods_price'],
                'goods_pay_price' => $datum['goods_price'] + $datum['goods_freight_price'],
                'goods_freight_price' => $datum['goods_freight_price'],
                'goods_discount_price' => $datum['goods_discount_price'],
                'goods_plat' => $datum['goods_plat'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        return $productData;
    }

    /**
     * 构建订单预览数据.
     */
    public static function buildOrderPreviewData(OrderServiceVo $vo): array
    {
        return [
            // 用户数据
            'user_data' => [
                'order_create_user_id' => $vo->getUserId(),
                'order_address' => [
                    'username' => $vo->orderFreightVo->userName,
                    'mobile' => $vo->orderFreightVo->userPhone,
                    'province_code' => $vo->orderFreightVo->provinceCode,
                    'province_name' => $vo->orderFreightVo->provinceName,
                    'city_code' => $vo->orderFreightVo->cityCode,
                    'city_name' => $vo->orderFreightVo->cityName,
                    'area_code' => $vo->orderFreightVo->areaCode,
                    'area_name' => $vo->orderFreightVo->areaName,
                    'street_name' => $vo->orderFreightVo->streetName,
                    'description' => $vo->orderFreightVo->description,
                ],
            ],
            // 订单价格数据
            'order_price_data' => [
                'order_price' => $vo->getOrderPrice(),
                'order_discount_price' => $vo->getOrderDiscountPrice(),
                'order_freight_price' => $vo->getOrderFreightPrice(),
                'order_pay_price' => $vo->getOrderPayPrice(),
            ],
            // 订单产品数据
            'product_data' => $vo->goodsData,
            'order_no' => $vo->getOrderNo(),
            'is_cart' => $vo->isCart,
        ];
    }
}
