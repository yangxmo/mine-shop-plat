<?php
declare (strict_types=1);

namespace App\Goods\Model;

use Mine\MineModel;

class GoodsAffiliate extends MineModel
{
    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected ?string $table = 'goods_affiliate';

    protected array $hidden = [
        'id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [
        'id', 'goods_no', 'goods_is_presell', 'goods_is_purchase', 'goods_purchase_type', 'goods_purchase_num', 'goods_is_vip', 'goods_buy_point', 'goods_sales', 'goods_unit', 'goods_logistics_type', 'goods_freight_type', 'goods_recommend', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'remark'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = [
        'goods_is_presell' => 'integer',
        'goods_is_purchase' => 'integer',
        'goods_purchase_type' => 'integer',
        'goods_purchase_num' => 'integer',
        'goods_is_vip' => 'integer',
        'goods_buy_point' => 'integer',
        'goods_sales' => 'integer',
        'goods_logistics_type' => 'integer',
        'goods_freight_type' => 'integer',
        'goods_recommend' => 'integer',
    ];


}