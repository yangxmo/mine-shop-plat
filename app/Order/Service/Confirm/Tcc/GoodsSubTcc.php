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

use App\Order\Service\Confirm\Service\GoodsService;
use App\Order\Vo\OrderServiceVo;
use Tcc\TccTransaction\TccOption;

class GoodsSubTcc extends TccOption
{
    protected OrderServiceVo $vo;

    # 处理商品信息
    public function try(): array
    {
        # 获取依赖数据
        $this->vo = $this->tcc->get(BuildOrderTcc::class);

        /** @var GoodsService $service */
        $service = make(GoodsService::class);

        # 扣除商品库存
        $service->subStock($this->vo);

        # 返回商品信息
        return $this->vo->getProductData();
    }

    public function confirm()
    {
        // 空提交
    }

    # 取消
    public function cancel(): void
    {
        # 解锁商品库存
        /** @var GoodsService $service */
        $service = make(GoodsService::class);
        $service->addStock($this->vo);
    }
}
