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

use Hyperf\Codec\Json;
use Mine\MineModel;

/**
 * @property mixed $term 
 */
class GoodsClause extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_clause';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'term', 'sort', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sort' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function setTermAttribute($value)
    {
        $this->attributes['term'] = Json::encode($value);
    }

    public function getTermAttribute($value)
    {
        return Json::decode($value);
    }
}
