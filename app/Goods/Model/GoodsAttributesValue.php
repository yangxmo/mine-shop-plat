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

use Mine\MineModel;

/**
 * @property int $id
 * @property string $goods_no
 * @property int $attr_no
 * @property int $attr_value_no
 * @property string $attr_value
 */
class GoodsAttributesValue extends MineModel
{
    public bool $timestamps = false;

    protected string $primaryKey = 'attr_no';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_attributes_value';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['goods_no', 'attr_no', 'attr_value_no', 'attr_value'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['attr_no' => 'integer', 'attr_value_no' => 'integer'];
}
