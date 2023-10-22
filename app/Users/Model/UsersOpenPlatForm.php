<?php

declare(strict_types=1);

namespace App\Users\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;

/**
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property string $open_id openID
 * @property string $union_id unionID
 * @property int $open_type 类型(1微信2百度3抖音)
 * @property string $avatar 头像
 * @property string $nickname 昵称
 * @property int $gender 性别(0女1男)
 * @property string $phone 手机号
 * @property string $email 邮箱
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class UsersOpenPlatForm extends MineModel
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users_open_plat_form';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'open_id', 'union_id', 'open_type', 'avatar', 'nickname', 'gender', 'phone', 'email', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'remark'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'user_id' => 'integer', 'open_type' => 'integer', 'gender' => 'integer', 'created_by' => 'integer', 'updated_by' => 'integer'];

    public function user()
    {
        return $this->hasOne(UsersUser::class, 'user_id', 'id');
    }

}
