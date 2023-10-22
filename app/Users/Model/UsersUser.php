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

namespace App\Users\Model;

use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;

/**
 * @property int $id 主键
 * @property string $mobile 手机号
 * @property string $email 邮箱
 * @property string $password 密码
 * @property string $nickname 用户昵称
 * @property string $avatar 用户头像
 * @property int $sex 用户性别
 * @property string $real_name 用户真实姓名
 * @property string $ip 用户新增时候的ip地址
 * @property string $last_ip 用户上一次登陆的ip地址
 * @property int $sign_in_days 用户连续签到天数
 * @property int $experience 用户会员经验进度
 * @property int $status 用户状态，含（正常，封禁）两种状态
 * @property int $level 用户会员等级
 * @property string $invite_code 用户邀请码
 * @property string $invite_code_by 用户邀请人
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property string $remark 备注
 */
class UsersUser extends MineModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users_user';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'mobile', 'email', 'password', 'nickname', 'avatar', 'sex', 'real_name', 'ip', 'last_ip', 'sign_in_days', 'experience', 'status', 'level', 'invite_code', 'invite_code_by', 'created_at', 'updated_at', 'deleted_at', 'remark'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sex' => 'integer', 'sign_in_days' => 'integer', 'experience' => 'integer', 'status' => 'integer', 'level' => 'integer'];
}
