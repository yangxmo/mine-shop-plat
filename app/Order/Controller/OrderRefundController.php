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
use App\Order\Request\OrderRefundRequest;
use App\Order\Service\OrderRefundService;
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
 * 订单退款控制器
 * Class OrderDeliveryController.
 */
#[Controller(prefix: 'order/refund'), Auth]
class OrderRefundController extends MineController
{
    #[Inject]
    protected OrderRefundService $service;

    /**
     * 获取订单列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('order:refund', 'order:refund:index')]
    public function index(OrderRefundRequest $request): ResponseInterface
    {
        $result = $this->service->getPageList($request->validated());
        return $this->success($result);
    }

    /**
     * 订单详情.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('read'), Permission('order:refund', 'order:refund:read')]
    public function read(OrderRefundRequest $request): ResponseInterface
    {
        $result = $this->service->orderInfo((int) $request->validated()['refund_order_no']);
        return $this->success($result);
    }

    /**
     * 订单售后审核.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('audit'), Permission('order:refund', 'order:refund:audit')]
    public function audit(OrderRefundRequest $request): ResponseInterface
    {
        $result = $this->service->audit($request->validated());
        return $result ? $this->success('审核成功') : $this->error('审核失败');
    }

    /**
     * 订单售后退款.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('refund'), Permission('order:refund', 'order:refund:refund')]
    public function refund(OrderRefundRequest $request): ResponseInterface
    {
        $result = $this->service->refund($request->validated());
        return $result ? $this->success('退款成功') : $this->error('退款失败');
    }

    /**
     * 订单退货审核.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('refundAudio'), Permission('order:refund', 'order:refund:refundAudio')]
    public function refundAudio(OrderRefundRequest $request): ResponseInterface
    {
        $result = $this->service->refundAudio($request->validated());
        return $result ? $this->success('发起退货审核成功') : $this->error('发起退货审核失败');
    }

    /**
     * 订单导出.
     */
    #[PostMapping('export'), Permission('order:refund', 'order:refund:export')]
    public function export(OrderBaseRequest $request): ResponseInterface
    {
        return $this->service->orderExport($request->validated());
    }
}
