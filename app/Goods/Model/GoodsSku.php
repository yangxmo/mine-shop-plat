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
namespace App\Goods\Model;

use App\Goods\Event\GoodsSkuEvent;
use Hyperf\Database\Model\Events\Deleted;
use Hyperf\Database\Model\Events\Updated;
use Mine\MineModel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @property string $goods_no
 * @property int $goods_sku_id
 * @property string $goods_sku_name
 * @property string $goods_sku_value
 * @property string $goods_sku_image
 * @property int $goods_sku_sale
 * @property int $goods_sku_lock_sale
 * @property string $goods_sku_price
 * @property string $goods_sku_market_price
 */
class GoodsSku extends MineModel
{
    public bool $timestamps = false;

    protected string $primaryKey = 'goods_sku_id';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_sku';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['goods_no', 'goods_attr_no', 'goods_sku_id', 'goods_sku_name', 'goods_sku_value', 'goods_sku_image', 'goods_sku_sale', 'goods_sku_lock_sale', 'goods_sku_price', 'goods_sku_market_price'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['goods_no' => 'integer', 'goods_sku_id' => 'integer', 'goods_sku_sale' => 'integer', 'goods_sku_lock_sale' => 'integer', 'goods_sku_price' => 'float', 'goods_sku_market_price' => 'float'];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updated(Updated $event): void
    {
        event(new GoodsSkuEvent($event));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function deleted(Deleted $event): void
    {
        event(new GoodsSkuEvent($event));
    }
}
