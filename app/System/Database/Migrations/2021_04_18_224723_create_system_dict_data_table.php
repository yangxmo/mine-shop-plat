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
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Mine\Abstracts\AbstractMigration;

class CreateSystemDictDataTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_dict_data', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('字典数据表');
            $table->bigIncrements('id')->comment('主键');
            $table->addColumn('bigInteger', 'type_id', ['unsigned' => true, 'comment' => '字典类型ID']);
            $table->addColumn('string', 'label', ['length' => 50, 'comment' => '字典标签'])->nullable();
            $table->addColumn('string', 'value', ['length' => 100, 'comment' => '字典值'])->nullable();
            $table->addColumn('string', 'code', ['length' => 100, 'comment' => '字典标示'])->nullable();
            $table->addColumn('smallInteger', 'sort', ['unsigned' => true, 'default' => 0, 'comment' => '排序'])->nullable();
            $table->addColumn('smallInteger', 'status', ['default' => 1, 'comment' => '状态 (1正常 2停用)'])->nullable();
            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
            $table->index('type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dict_data');
    }
}
