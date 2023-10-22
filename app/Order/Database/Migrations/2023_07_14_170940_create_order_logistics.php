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
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Mine\Abstracts\AbstractMigration;

class CreateOrderLogistics extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_logistics', function (Blueprint $table) {
            $table->string('order_no');
            $table->comment('订单物流表');
            $table->foreign('order_no')->references('order_no')->on('order_base')->comment('订单唯一号');
            $table->string('logistics_name', 20)->comment('物流公司名称');
            $table->string('logistics_no', 50)->comment('物流单号');
            $table->string('sku_id', 30)->comment('发货的产品ID');
            $table->timestamp('delivered_time')->nullable()->comment('发货时间');
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_logistics');
    }
}
