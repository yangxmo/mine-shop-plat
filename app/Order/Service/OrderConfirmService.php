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
namespace App\Order\Service;

use App\Order\Service\Confirm\Tcc\BuildOrderTcc;
use App\Order\Service\Confirm\Tcc\GoodsLockTcc;
use App\Order\Service\Confirm\Tcc\GoodsSubTcc;
use App\Order\Service\Confirm\Tcc\OrderMessageTcc;
use App\Order\Service\Confirm\Tcc\OrderStatisticsTcc;
use App\Order\Service\Confirm\Tcc\OrderTcc;
use App\Order\Service\Preview\Interface\OrderPreviewInterface;
use App\Order\Vo\OrderAddressVo;
use App\Order\Vo\OrderServiceVo;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Tcc\TccTransaction\Tcc;

class OrderConfirmService extends AbstractService
{
    #[Inject]
    protected OrderPreviewInterface $orderPreview;

    /**
     * 订单预览.
     */
    public function getPreviewOrder(array $data): array
    {
        // 设置订单运费对象属性
        /** @var OrderAddressVo $orderFreightVo */
        $orderFreightVo = make(OrderAddressVo::class);
        $orderFreightVo->provinceName = $data['address']['province_name'];
        $orderFreightVo->provinceCode = $data['address']['province_code'];
        $orderFreightVo->cityName = $data['address']['city_name'];
        $orderFreightVo->cityCode = $data['address']['city_code'];
        $orderFreightVo->areaName = $data['address']['area_name'];
        $orderFreightVo->areaCode = $data['address']['area_code'];
        $orderFreightVo->streetName = $data['address']['street_name'];
        $orderFreightVo->streetCode = $data['address']['street_code'] ?? 0;
        $orderFreightVo->description = $data['address']['description'];
        $orderFreightVo->userName = $data['address']['username'];
        $orderFreightVo->userPhone = $data['address']['mobile'];

        // 设置订单对象属性
        /** @var OrderServiceVo $orderServiceVo */
        $orderServiceVo = make(OrderServiceVo::class);
        $orderServiceVo->setUserId(user()->getId());
        $orderServiceVo->setGoodsData($data['goods']);
        $orderServiceVo->setOrderFreight($orderFreightVo);
        $orderServiceVo->setIsCart($data['is_cart']);

        // 获取订单数据
        return $this->orderPreview->init($orderServiceVo)->getPreviewOrder();
    }

    /**
     * 创建订单.
     */
    public function confirm(int $previewOrderId): array
    {
        /**
         * 创建订单使用TCC分布式事务，后续可扩展为RPC微服务形式进行处理
         * 使用tcc 时，tcc节点服务，必须继承tccOption 如BuildOrderTcc
         * 务必在tcc节点服务中定义 try，cancel，confirm 三个方法，并实现接口方法
         * 此tcc中暂只支持 throw 形式的异常抛出处理.
         */

        /** @var Tcc $tcc */
        $tcc = make(Tcc::class);

        // 第一步构建订单数据
        $tcc->tcc(1, new BuildOrderTcc($previewOrderId))
            // 第二步商品锁定库存（此步骤不操作数据库，因订单还未真正创建成功，此步骤是为了锁定库存，防止高流量进入）
            ->tcc(2, new GoodsLockTcc())
            // 第三步创建真实订单，以及订单商品，下单地址，等并入库
            ->tcc(3, new OrderTcc())
            // 产品真正开始扣减库存，（扣减已锁定的库存，扣减数据库商品库存）
            ->tcc(4, new GoodsSubTcc())
            // 订单信息通知，进行短信通知或其他处理
            ->tcc(5, new OrderMessageTcc())
            // 订单统计，计算用户下单数等等
            ->tcc(6, new OrderStatisticsTcc())
            // 设置执行步骤
            ->rely([
                [1, 2], // 第一步，进行数据组装，检查产品等数据，并锁定商品库存
                [3], // 创建订单，创建的子订单数据（商品，地址，待支付记录，主订单数据）
                [4, 5, 6], // 订单创建成功，商品真实扣除，扣除redis 库存，扣除锁定的库存，数据库商品库存扣减，发送下单成功消息通知，进行后续处理，以及订单统计
            ])->begin();

        return ['order_id' => $tcc->get(OrderTcc::class)->id];
    }
}
