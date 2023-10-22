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
namespace App\Order\Service\Preview\Abstract;

use App\Order\Assemble\OrderAssemble;
use App\Order\Service\Preview\Interface\OrderPreviewInterface;
use App\Order\Trait\OrderPriceTrait;
use App\Order\Vo\OrderServiceVo;
use Mine\Exception\MineException;

abstract class OrderPreviewAbstract implements OrderPreviewInterface
{
    use OrderPriceTrait;

    public OrderServiceVo $orderVo;

    protected ?array $errorMessage;

    // 检查商品
    abstract public function checkOrderProduct(): self;

    // 检查商品总价
    abstract public function checkOrderProductPayPrice(): self;

    // 构建所需产品数据
    abstract public function buildGoodsInfo(): self;

    // 后续操作
    abstract public function after(string $orderNo, array $confirmOrder);

    # 初始化
    public function init(OrderServiceVo $orderServiceVo): self
    {
        $this->orderVo = $orderServiceVo;
        return $this;
    }

    # 设置错误信息
    public function setOrderError(string $message): void
    {
        if (! empty($message)) {
            throw new MineException($message);
        }
    }

    # 获取订单确认页信息
    public function getPreviewOrder(): array
    {
        # 构建产品数据
        $this->buildGoodsInfo();
        # 检查订单产品信息
        $this->checkOrderProduct();
        # 检查计算订单产品价格
        $this->checkOrderProductPayPrice();
        // 获取订单号
        $orderNo = snowflake_id($this->orderVo->getUserId());
        // 设置单号
        $this->orderVo->setOrderNo((int) $orderNo);
        // 构建订单预览数据
        $previewData = OrderAssemble::buildOrderPreviewData($this->orderVo);
        // 设置确认订单页面缓存
        $this->after($orderNo, $previewData);

        return $previewData;
    }
}
