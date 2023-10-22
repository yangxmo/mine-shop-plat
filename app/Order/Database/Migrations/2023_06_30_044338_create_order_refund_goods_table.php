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

class CreateOrderRefundGoodsTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_refund_goods', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('订单退款商品表');
            $table->unsignedBigInteger('refund_order_no');
            $table->foreign('refund_order_no')->references('refund_order_no')->on('order_refund')->comment('订单退款唯一号');
            $table->string('refund_goods_name', 50)->comment('产品名称');
            $table->string('refund_goods_image', 255)->comment('产品图片');
            $table->bigInteger('refund_goods_no')->comment('产品编号');
            $table->bigInteger('refund_goods_sku_no')->nullable()->comment('产品sku');
            $table->integer('refund_goods_num')->default(1)->comment('产品退款数量');
            $table->decimal('refund_goods_old_price', 10, 2)->comment('产品原价格');
            $table->decimal('refund_goods_price', 10, 2)->comment('产品退款价格');
            $table->string('refund_remark', 150)->default('')->comment('退款备注');
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
        Schema::dropIfExists('order_refund_goods');
    }
}
