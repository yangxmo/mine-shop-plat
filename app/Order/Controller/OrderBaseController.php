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
use App\Order\Service\OrderBaseService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 订单控制器
 * Class OrderBaseController.
 */
#[Controller(prefix: 'order/base'), Auth]
class OrderBaseController extends MineController
{
    #[Inject]
    protected OrderBaseService $service;

    /**
     * 获取订单列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('order:base', 'order:base:index')]
    public function index(OrderBaseRequest $request): ResponseInterface
    {
        $result = $this->service->getPageList($request->validated());
        return $this->success($result);
    }

    /**
     * 获取订单产品
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('getGoodsList/{orderNo}')]
    public function getGoodsList(int $orderNo): ResponseInterface
    {
        $result = $this->service->getGoodsList($orderNo);
        return $this->success($result);
    }

    /**
     * 订单详情.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('read'), Permission('order:base', 'order:base:read')]
    public function read(OrderBaseRequest $request): ResponseInterface
    {
        $result = $this->service->read((int) $request->input('order_no'));
        return $this->success($result);
    }

    /**
     * 订单取消.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PutMapping('cancel'), Permission('order:base', 'order:base:cancel')]
    public function cancel(OrderBaseRequest $request): ResponseInterface
    {
        $this->service->orderCancel((int) $request->input('order_no'));
        return $this->success();
    }

    /**
     * 订单统计
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('statistics'), Permission('order:base', 'order:base:statistics')]
    public function orderStatistics(OrderBaseRequest $request): ResponseInterface
    {
        $result = $this->service->orderStatistics($request->input('order_date'));
        return $this->success($result);
    }

    /**
     * 订单导出.
     */
    #[PostMapping('export'), Permission('order:base', 'order:base:export')]
    public function export(OrderBaseRequest $request): ResponseInterface
    {
        return $this->service->orderExport($request->validated());
    }
}
