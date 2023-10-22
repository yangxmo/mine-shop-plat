<?php
namespace App\Users\Dto;

use Mine\Interfaces\MineModelExcel;
use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;

/**
 * 用户数据表Dto （导入导出）
 */
#[ExcelData]
class UserDataDto implements MineModelExcel
{
    #[ExcelProperty(value: "主键", index: 0)]
    public string $id;

    #[ExcelProperty(value: "手机号", index: 1)]
    public string $mobile;

    #[ExcelProperty(value: "邮箱", index: 2)]
    public string $email;

    #[ExcelProperty(value: "用户名", index: 3)]
    public string $username;

    #[ExcelProperty(value: "密码", index: 4)]
    public string $password;

    #[ExcelProperty(value: "用户昵称", index: 5)]
    public string $nickname;

    #[ExcelProperty(value: "用户头像", index: 6)]
    public string $avatar;

    #[ExcelProperty(value: "用户性别", index: 7)]
    public string $sex;

    #[ExcelProperty(value: "用户真实姓名", index: 8)]
    public string $real_name;

    #[ExcelProperty(value: "用户新增时候的ip地址", index: 9)]
    public string $ip;

    #[ExcelProperty(value: "用户上一次登陆的ip地址", index: 10)]
    public string $last_ip;

    #[ExcelProperty(value: "用户连续签到天数", index: 11)]
    public string $sign_in_days;

    #[ExcelProperty(value: "用户会员经验进度", index: 12)]
    public string $experience;

    #[ExcelProperty(value: "用户状态，含（正常，封禁）两种状态", index: 13)]
    public string $status;

    #[ExcelProperty(value: "用户会员等级", index: 14)]
    public string $level;

    #[ExcelProperty(value: "用户邀请码", index: 15)]
    public string $invite_code;

    #[ExcelProperty(value: "用户邀请人", index: 16)]
    public string $invite_code_by;

    #[ExcelProperty(value: "创建时间", index: 17)]
    public string $created_at;

    #[ExcelProperty(value: "更新时间", index: 18)]
    public string $updated_at;

    #[ExcelProperty(value: "删除时间", index: 19)]
    public string $deleted_at;

    #[ExcelProperty(value: "备注", index: 20)]
    public string $remark;


}