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

class CreateGoodsSku extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_sku', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_no');
            $table->foreign('goods_no')->references('id')->on('goods')->comment('商品编号');
            $table->string('goods_sku_id', 50)->unique()->comment('商品sku唯一标识');
            $table->string('goods_sku_name', 150)->default('')->comment('商品sku名称');
            $table->string('goods_sku_value', 150)->default('')->comment('sku属性ID所对应的显示名，比如颜色，尺码');
            $table->string('goods_sku_image', 255)->default('')->comment('商品sku图片');
            $table->bigInteger('goods_sku_sale')->default(0)->comment('商品sku库存');
            $table->decimal('goods_sku_price')->default(0.00)->comment('商品sku销售价格');
            $table->decimal('goods_sku_market_price')->default(0.00)->comment('商品sku 市场价');

            $table->index(['goods_no', 'goods_sku_id'], 'idx_goods_no_id');
            $table->comment('商品sku表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_sku');
    }
}
