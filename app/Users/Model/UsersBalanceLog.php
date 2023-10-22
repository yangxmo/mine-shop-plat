<?php

declare(strict_types=1);

namespace App\Users\Model;

use Mine\MineModel;

/**
 */
class UsersBalanceLog extends MineModel
{
    public bool $timestamps = false;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users_balance_log';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'amount', 'type', 'status', 'before_balance', 'after_balance', 'remark', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];

    public static array $selectField = ['id', 'user_id', 'amount', 'type', 'status', 'before_balance', 'after_balance', 'remark', 'created_at'];

    /**
     * 定义 userInfo 关联
     * @return \Hyperf\Database\Model\Relations\hasOne
     */
    public function userInfo() : \Hyperf\Database\Model\Relations\hasOne
    {
        return $this->hasOne(\App\Users\Model\UsersUser::class, 'id', 'user_id')->select(['id', 'nickname']);
    }
}
