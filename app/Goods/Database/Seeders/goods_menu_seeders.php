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

class GoodsMenuSeeders extends AbstractSeeder
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
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (0, '0', '产品', 'product', 'icon-home', 'goods', 'goods', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
            'SET @goods_id := LAST_INSERT_ID()',
            "SET @goods_level := CONCAT('0', ',', @goods_id)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@goods_id, @goods_level, '商品管理', CONCAT('goods:manage',':index'), 'icon-home', 'goods:manage', 'goods/manage/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @id := LAST_INSERT_ID()',
            "SET @level := CONCAT('0', ',', @id)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '列表'), CONCAT('goods:manage',':index'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '保存'), CONCAT('goods:manage',':save'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '更新'), CONCAT('goods:manage',':update'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '读取'), CONCAT('goods:manage',':read'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '删除'), CONCAT('goods:manage',':delete'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '回收站'), CONCAT('goods:manage',':recycle'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '恢复'), CONCAT('goods:manage',':recovery'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '真实删除'), CONCAT('goods:manage',':realDelete'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '导入'), CONCAT('goods:manage',':import'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '导出'), CONCAT('goods:manage',':export'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            // 商品分类
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@goods_id, @goods_level, '商品分类', CONCAT('goods:category',':index'), 'icon-home', 'goods:category', 'goods/manage/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @cid := LAST_INSERT_ID()',
            "SET @clevel := CONCAT('0', ',', @cid)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '列表'), CONCAT('goods:category',':index'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '保存'), CONCAT('goods:category',':save'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '更新'), CONCAT('goods:category',':update'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '读取'), CONCAT('goods:category',':read'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '删除'), CONCAT('goods:category',':delete'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '回收站'), CONCAT('goods:category',':recycle'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '恢复'), CONCAT('goods:category',':recovery'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '真实删除'), CONCAT('goods:category',':realDelete'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '导入'), CONCAT('goods:category',':import'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@cid, @clevel, CONCAT('商品分类', '导出'), CONCAT('goods:category',':export'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `ms_system_menu`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@goods_id, @goods_level, '服务模板', 'goods:clause', 'icon-home', 'goods/clause', 'goods/clause/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @clause_id := LAST_INSERT_ID()',
            "SET @clause_level := CONCAT('0', ',', @goods_id)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@clause_id, @clause_level, CONCAT('服务模板', '列表'), CONCAT('goods:clause',':index'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@clause_id, @clause_level, CONCAT('服务模板', '保存'), CONCAT('goods:clause',':save'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@clause_id, @clause_level, CONCAT('服务模板', '更新'), CONCAT('goods:clause',':update'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@clause_id, @clause_level, CONCAT('服务模板', '读取'), CONCAT('goods:clause',':read'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@clause_id, @clause_level, CONCAT('服务模板', '删除'), CONCAT('goods:clause',':delete'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            ];
    }
}
