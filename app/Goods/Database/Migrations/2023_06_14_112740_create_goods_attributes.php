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

class CreateGoodsAttributes extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_no');
            $table->foreign('goods_no')->references('id')->on('goods')->comment('商品编号');
            $table->integer('goods_category_id')->nullable()->comment('商品分类ID');
            $table->bigInteger('attributes_no')->comment('商品属性编号');
            $table->string('attributes_name')->comment('商品属性名');

            $table->comment('商品属性表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_attributes');
    }
}
