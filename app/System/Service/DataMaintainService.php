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
namespace App\System\Service;

use Hyperf\Database\Model\Collection;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\AbstractService;
use Mine\Kernel\Tenant\Tenant;

class DataMaintainService extends AbstractService
{
    /**
     * 获取表状态分页列表.
     */
    public function getPageList(?array $params = [], bool $isScope = true): array
    {
        return $this->getArrayToPageList($params);
    }

    /**
     * 获取表字段.
     * @param string $table
     */
    public function getColumnList(mixed $table): array
    {
        if ($table) {
            // 从数据库中获取表字段信息
            $sql = 'SELECT * FROM `information_schema`.`columns` '
                . 'WHERE TABLE_SCHEMA = ? AND table_name = ? '
                . 'ORDER BY ORDINAL_POSITION';
            // 加载主表的列
            $columnList = [];
            $databaseName = env('DB_DATABASE') . '_' .Tenant::instance()->getId();
            foreach (Db::select($sql, [$databaseName, $table]) as $column) {
                $columnList[] = [
                    'column_key' => $column->COLUMN_KEY,
                    'column_name' => $column->COLUMN_NAME,
                    'data_type' => $column->DATA_TYPE,
                    'column_comment' => $column->COLUMN_COMMENT,
                    'extra' => $column->EXTRA,
                    'column_type' => $column->COLUMN_TYPE,
                    'is_nullable' => $column->IS_NULLABLE,
                ];
            }
            return $columnList;
        }
        return [];
    }

    /**
     * 优化表.
     */
    public function optimize(array $tables): bool
    {
        foreach ($tables as $table) {
            Db::select('optimize table `?`', [$table]);
        }
        return true;
    }

    /**
     * 清理表碎片.
     */
    public function fragment(array $tables): bool
    {
        foreach ($tables as $table) {
            Db::select('analyze table `?`', [$table]);
        }
        return true;
    }

    /**
     * 数组数据搜索器.
     * @return Collection
     */
    protected function handleArraySearch(\Hyperf\Utils\Collection $collect, array $params): \Hyperf\Utils\Collection
    {
        if ($params['name'] ?? false) {
            $collect = $collect->filter(function ($row) use ($params) {
                return \Mine\Helper\Str::contains($row->Name, $params['name']);
            });
        }
        if ($params['engine'] ?? false) {
            $collect = $collect->where('Engine', $params['engine']);
        }
        return $collect;
    }

    /**
     * 数组当前页数据返回之前处理器，默认对key重置.
     */
    protected function getCurrentArrayPageBefore(array &$data, array $params = []): array
    {
        $tables = [];
        foreach ($data as $item) {
            $tables[] = array_change_key_case((array) $item);
        }
        return $tables;
    }

    /**
     * 设置需要分页的数组数据.
     */
    protected function getArrayData(array $params = []): array
    {
        return Db::select(Db::raw("SHOW TABLE STATUS WHERE name NOT LIKE '%migrations'")->getValue());
    }
}
