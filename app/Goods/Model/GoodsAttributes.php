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
 * @property int $goods_no 
 * @property int $goods_category_id 商品分类ID
 * @property int $attr_no 商品属性编号
 * @property string $attributes_name 商品属性名
 * @property-read \Hyperf\Database\Model\Collection[]|null $attributeValue
 */
class GoodsAttributes extends MineModel
{
    public bool $timestamps = false;

    protected string $primaryKey = 'attr_no';

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_attributes';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['goods_no', 'attr_no', 'attributes_name'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['goods_no' => 'integer', 'attr_no' => 'integer'];

    public function attributeValue(): \Hyperf\Database\Model\Relations\HasMany
    {
        return $this->hasMany(GoodsAttributesValue::class, 'attr_no', 'attr_no');
    }
}
