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

namespace App\Order\Controller;

use App\Order\Request\OrderBaseRequest;
use App\Order\Request\OrderDeliveryRequest;
use App\Order\Service\OrderBaseService;
use App\Order\Service\OrderDeliveryService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 订单发货控制器
 * Class OrderDeliveryController.
 */
#[Controller(prefix: 'order/delivery'), Auth]
class OrderDeliveryController extends MineController
{
    #[Inject]
    protected OrderDeliveryService $service;

    #[Inject]
    protected OrderBaseService $orderBaseService;

    /**
     * 获取订单列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('order:delivery', 'order:delivery:index')]
    public function index(OrderBaseRequest $request): ResponseInterface
    {
        $result = $this->orderBaseService->getPageList($request->validated());
        return $this->success($result);
    }

    /**
     * 订单详情.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('read'), Permission('order:delivery', 'order:delivery:read')]
    public function read(OrderBaseRequest $request): ResponseInterface
    {
        $result = $this->orderBaseService->orderInfo($request->input('order_no'));
        return $this->success($result);
    }

    /**
     * 订单发货.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('delivery'), Permission('order:delivery', 'order:delivery:delivery')]
    public function delivery(OrderDeliveryRequest $request): ResponseInterface
    {
        $result = $this->service->delivery($request->validated());
        return $result ? $this->success('发货成功') : $this->error('发货失败');
    }

    /**
     * 获取物流列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('logisticsTypeList')]
    public function logisticsTypeList(): ResponseInterface
    {
        return $this->success([
            ['value' => 1, 'label' => '顺丰快递'],
            ['value' => 2, 'label' => '圆通快递'],
            ['value' => 3, 'label' => '中通快递'],
            ['value' => 4, 'label' => '韵达快递'],
            ['value' => 5, 'label' => '申通快递'],
            ['value' => 6, 'label' => '百世快递'],
            ['value' => 7, 'label' => '邮政快递'],
            ['value' => 8, 'label' => 'EMS快递'],
            ['value' => 9, 'label' => '其他快递'],
        ]);
    }

    /**
     * 订单修改发货.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('editDelivery'), Permission('order:delivery', 'order:delivery:delivery')]
    public function editDelivery(OrderDeliveryRequest $request): ResponseInterface
    {
        $result = $this->service->delivery($request->validated());
        return $result ? $this->success('发货成功') : $this->error('发货失败');
    }

    /**
     * 订单导出.
     */
    #[PostMapping('export'), Permission('order:delivery', 'order:delivery:export')]
    public function export(OrderBaseRequest $request): ResponseInterface
    {
        return $this->service->orderExport($request->validated());
    }
}
