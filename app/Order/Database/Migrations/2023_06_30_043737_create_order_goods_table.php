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

class CreateOrderGoodsTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->engine = 'InnoDb';
            $table->comment('订单产品表');
            $table->string('order_no');
            $table->foreign('order_no')->references('order_no')->on('order_base')->comment('订单唯一号');
            $table->string('goods_name', 50)->comment('产品名称');
            $table->string('goods_sku_name', 150)->nullable()->comment('产品sku名称');
            $table->string('goods_sku_value', 150)->nullable()->comment('产品sku值');
            $table->string('goods_image', 255)->comment('产品图片');
            $table->bigInteger('goods_no')->comment('产品编号');
            $table->bigInteger('goods_sku_no')->nullable()->comment('产品sku');
            $table->integer('goods_num')->default(1)->comment('产品购买数量');
            $table->decimal('goods_price', 10, 2)->default(0.00)->comment('产品价格');
            $table->decimal('goods_freight_price', 10, 2)->default(0.00)->comment('产品运费价格');
            $table->decimal('goods_discount_price', 10, 2)->default(0.00)->comment('产品优惠价格');
            $table->decimal('goods_pay_price', 10, 2)->default(0.00)->comment('产品实际支付价格');
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
        Schema::dropIfExists('order_goods');
    }
}
