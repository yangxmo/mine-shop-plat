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

use App\Order\Request\OrderPayRequest;
use App\Order\Request\OrderPreviewRequest;
use App\Order\Service\OrderConfirmService;
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
 * 订单控制器
 * Class OrderConfirmController.
 */
#[Controller(prefix: 'order/confirm'), Auth]
class OrderConfirmController extends MineController
{
    /**
     * 业务处理服务
     * OrderConfirmService.
     */
    #[Inject]
    protected OrderConfirmService $service;

    /**
     * 获取订单预览.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('getOrderPreview'), Permission('order:confirm:getOrderPreview')]
    public function getOrderPreview(OrderPreviewRequest $request): ResponseInterface
    {
        $result = $this->service->getPreviewOrder($request->validated());

        return $this->success($result);
    }

    /**
     * 提交订单.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('confirm'), Permission('order:confirm:confirm')]
    public function confirm(OrderPayRequest $request): ResponseInterface
    {
        $orderNo = $request->input('order_no', '');
        $result = $this->service->confirm($orderNo);

        return $this->success($result);
    }
}
