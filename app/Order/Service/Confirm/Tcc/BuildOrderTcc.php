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
namespace App\Order\Service\Confirm\Tcc;

use App\Order\Cache\OrderCache;
use App\Order\Vo\OrderAddressVo;
use App\Order\Vo\OrderServiceVo;
use Hyperf\Di\Annotation\Inject;
use Mine\Exception\MineException;
use Tcc\TccTransaction\TccOption;

class BuildOrderTcc extends TccOption
{
    #[Inject]
    protected OrderCache $orderCache;

    protected int $previewOrderId;

    public function __construct(int $previewOrderId)
    {
        $this->previewOrderId = $previewOrderId;
    }

    # 构建订单
    public function try(): OrderServiceVo
    {
        // 返回确认页面
        $orderInfo = $this->orderCache->getConfirmCache($this->previewOrderId);

        if (empty($orderInfo)) {
            throw new MineException(t('order.confirm_order_timeout'));
        }

        /** @var OrderAddressVo $orderFreightVo */
        $orderFreightVo = make(OrderAddressVo::class);
        $orderFreightVo->productInfo = $orderInfo['product_data'];
        $orderFreightVo->userName = $orderInfo['user_data']['order_address']['username'];
        $orderFreightVo->userPhone = $orderInfo['user_data']['order_address']['mobile'];
        $orderFreightVo->provinceName = $orderInfo['user_data']['order_address']['province_name'];
        $orderFreightVo->provinceCode = $orderInfo['user_data']['order_address']['province_code'];
        $orderFreightVo->cityName = $orderInfo['user_data']['order_address']['city_name'];
        $orderFreightVo->cityCode = $orderInfo['user_data']['order_address']['city_code'];
        $orderFreightVo->areaName = $orderInfo['user_data']['order_address']['area_name'];
        $orderFreightVo->areaCode = $orderInfo['user_data']['order_address']['area_code'];
        $orderFreightVo->streetName = $orderInfo['user_data']['order_address']['street_name'];
        $orderFreightVo->description = $orderInfo['user_data']['order_address']['description'];

        // 设置订单对象属性
        /** @var OrderServiceVo $orderServiceVo */
        $orderServiceVo = make(OrderServiceVo::class);
        $orderServiceVo->setUserId((int) $orderInfo['user_data']['order_create_user_id']);
        $orderServiceVo->setTenantId($orderInfo['user_data']['order_tenant_no']);
        $orderServiceVo->setGoodsData($orderInfo['product_data']);
        $orderServiceVo->setOrderFreightPrice((float) $orderInfo['order_price_data']['order_freight_price']);
        $orderServiceVo->setOrderPrice((float) $orderInfo['order_price_data']['order_price']);
        $orderServiceVo->setOrderPayPrice((float) $orderInfo['order_price_data']['order_pay_price']);
        $orderServiceVo->setOrderDiscountPrice((float) $orderInfo['order_price_data']['order_discount_price']);
        $orderServiceVo->setOrderFreight($orderFreightVo);
        $orderServiceVo->setIsCart((bool) $orderInfo['is_cart']);
        $orderServiceVo->setOrderNo($this->previewOrderId);

        return $orderServiceVo;
    }

    public function cancel()
    {
        // TODO: Implement cancel() method.
    }

    public function confirm()
    {
        // TODO: Implement confirm() method.
    }
}
