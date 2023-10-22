<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\Users\Request;

use Hyperf\Validation\Rule;
use Mine\MineFormRequest;

/**
 * 用户数据表验证数据类
 */
class UserRequest extends MineFormRequest
{
    /**
     * 公共规则
     */
    public function commonRules(): array
    {
        return [];
    }


    /**
     * 新增数据验证规则
     * return array
     */
    public function saveRules(): array
    {
        return [
            //手机号 验证
            'mobile' => ['required', Rule::unique('user_data'), 'regex:/^1[3456789]\d{9}$/'],
            //邮箱 验证
            'email' => ['required', 'regex:/^.+@.+$/i'],
            //密码 验证
            'password' => 'required|min:6|max:10',
            //用户昵称 验证
            'nickname' => 'nullable|max:10',
            //用户性别 验证
            'sex' => 'required|integer|in:1,2',
            //用户状态，含（正常，封禁）两种状态 验证
            'status' => 'required|integer|in:1,2',
            //用户会员等级 验证
            'level' => 'required|integer|in:1,2,3,4,5',
        ];
    }

    /**
     * 更新数据验证规则
     * return array
     */
    public function updateRules(): array
    {
        return [
            //手机号 验证
            'mobile' => ['required', Rule::unique('user_data')->ignore($this->route('id'), 'id'), 'regex:/^1[3456789]\d{9}$/'],
            //邮箱 验证
            'email' => ['required', 'regex:/^.+@.+$/i'],
            //密码 验证
            'password' => 'required|min:6|max:10',
            //用户昵称 验证
            'nickname' => 'nullable|max:10',
            //用户性别 验证
            'sex' => 'required|integer|in:1,2',
            //用户状态，含（正常，封禁）两种状态 验证
            'status' => 'required|integer|in:1,2',
            //用户会员等级 验证
            'level' => 'required|integer|in:1,2,3,4,5',
        ];
    }


    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => '主键',
            'mobile' => '手机号',
            'password' => '密码',
            'nickname' => '用户昵称',
            'sex' => '用户性别',
            'status' => '用户状态，含（正常，封禁）两种状态',
            'level' => '用户会员等级',
        ];
    }

}