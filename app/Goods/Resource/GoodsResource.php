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

namespace App\Goods\Resource;

use Hyperf\Codec\Json;
use Hyperf\Collection\Arr;
use Hyperf\Resource\Json\ResourceCollection;
use function Clue\StreamFilter\fun;

/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
class GoodsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        $newData[] = Arr::mapWithKeys($this->collection['items'], function ($datum) use (&$newData) {
            $goods = [
                'id' => $datum['id'],
                'goods_name' => $datum['goods_name'] ?? '',
                'goods_type' => $datum['goods_type'] ?? 1,
                'goods_category_id' => $datum['goods_category_id'] ?? 0,
                'goods_images' => $datum['goods_images'] ? Json::decode($datum['goods_images']) : [],
                'goods_image' => $datum['goods_images'] ? Json::decode($datum['goods_images'])[0] ?? '' : '',
                'goods_status' => $datum['goods_status'] ?? 2,
                'goods_sale' => $datum['goods_sale'] ?? 0,
                'goods_language' => $datum['goods_language'],
                'goods_price' => $datum['goods_price'],
                'goods_market_price' => $datum['goods_market_price'],
                'goods_category_name' => $datum->category->title ?? '-',
                'goods_description' => $datum['goods_description'],
                'created_at' => $datum['created_at']->toDateTimeString(),
            ];

            return array_merge($goods, $datum->affiliate->toArray());
        });

        return ['items' => $newData, 'pageInfo' => $this->collection['pageInfo']];
    }
}
