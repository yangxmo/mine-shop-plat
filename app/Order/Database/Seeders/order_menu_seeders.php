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
use App\System\Model\SystemMenu;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\AbstractSeeder;

class OrderMenuSeeders extends AbstractSeeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->getData() as $item) {
            Db::insert($item);
        }
    }

    public function getData(): array
    {
        $model = env('DB_PREFIX') . SystemMenu::getModel()->getTable();
        return [
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (0, '0', '订单', 'order', 'IconNav', 'order', NULL, NULL, '2', 'M', '1', 998, 1, NULL, now(), now(), NULL, NULL)",

            'SET @order_id := LAST_INSERT_ID()',
            "SET @order_level := CONCAT('0', ',', @order_id)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@order_id, @order_level, '订单管理', 'order:base', 'IconDragDotVertical', 'order/base', 'order/base/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @id := LAST_INSERT_ID()',
            "SET @level := CONCAT('0', ',', @id)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('订单管理', '列表'), CONCAT('order:base',':index'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('订单管理', '读取'), CONCAT('order:base',':read'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('订单管理', '导出'), CONCAT('order:base',':export'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('订单管理', '取消'), CONCAT('order:base',':cancel'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            // 订单发货
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (4739, '0,4739', '发货管理', 'order:delivery', 'IconDragDotVertical', 'order/delivery', 'order/delivery/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @delivery_id := LAST_INSERT_ID()',
            "SET @delivery_level := CONCAT('0', ',', @delivery_id)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@delivery_id, @delivery_level, CONCAT('发货管理', '列表'), CONCAT('order:delivery',':index'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@delivery_id, @delivery_level, CONCAT('发货管理', '读取'), CONCAT('order:delivery',':read'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@delivery_id, @delivery_level, CONCAT('发货管理', '发货'), CONCAT('order:delivery',':delivery'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@delivery_id, @delivery_level, CONCAT('发货管理', '修改发货'), CONCAT('order:editDelivery',':editDelivery'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@delivery_id, @delivery_level, CONCAT('发货管理', '导出'), CONCAT('order:delivery',':export'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (0, '0', '售后', 'refund', 'IconStrikethrough', 'refund', NULL, NULL, '2', 'M', '1', 997, 1, NULL, now(), now(), NULL, NULL)",

            'SET @refund_id := LAST_INSERT_ID()',
            "SET @refund_level := CONCAT('0', ',', @refund_id)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_id, @refund_level, '售后管理', 'order:refund', 'IconDragDotVertical', 'order/refund', 'order/refund/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @refund_ids := LAST_INSERT_ID()',
            "SET @refund_levels := CONCAT('0', ',', @refund_ids)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_ids, @refund_levels, CONCAT('售后管理', '列表'), CONCAT('order:refund',':index'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_ids, @refund_levels, CONCAT('售后管理', '读取'), CONCAT('order:refund',':read'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_ids, @refund_levels, CONCAT('售后管理', '审核'), CONCAT('order:refund',':audit'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_ids, @refund_levels, CONCAT('售后管理', '退款'), CONCAT('order:refund',':refund'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_ids, @refund_levels, CONCAT('售后管理', '退货审核'), CONCAT('order:refund',':refundAudio'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@refund_ids, @refund_levels, CONCAT('售后管理', '导出'), CONCAT('order:refund',':export'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
        ];
    }
}
