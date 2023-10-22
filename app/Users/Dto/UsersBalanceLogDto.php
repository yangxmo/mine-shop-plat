<?php
namespace App\Users\Dto;

use Mine\Interfaces\MineModelExcel;
use Mine\Annotation\ExcelData;
use Mine\Annotation\ExcelProperty;

/**
 * 表注释Dto （导入导出）
 */
#[ExcelData]
class UsersBalanceLogDto implements MineModelExcel
{
    #[ExcelProperty(value: "主键", index: 0)]
    public string $id;

    #[ExcelProperty(value: "用户ID", index: 1)]
    public string $user_id;

    #[ExcelProperty(value: "交易类型(1:充值,2:提现,3:转账,4:退款,5:扣款,6:系统)", index: 2)]
    public string $type;

    #[ExcelProperty(value: "交易金额", index: 3)]
    public string $amount;

    #[ExcelProperty(value: "交易状态(1:成功,2:失败,3:处理中", index: 4)]
    public string $status;

    #[ExcelProperty(value: "交易前余额", index: 5)]
    public string $before_balance;

    #[ExcelProperty(value: "交易后余额", index: 6)]
    public string $after_balance;

    #[ExcelProperty(value: "创建者", index: 7)]
    public string $created_by;

    #[ExcelProperty(value: "更新者", index: 8)]
    public string $updated_by;

    #[ExcelProperty(value: "创建时间", index: 9)]
    public string $created_at;

    #[ExcelProperty(value: "更新时间", index: 10)]
    public string $updated_at;

    #[ExcelProperty(value: "删除时间", index: 11)]
    public string $deleted_at;

    #[ExcelProperty(value: "备注", index: 12)]
    public string $remark;


}