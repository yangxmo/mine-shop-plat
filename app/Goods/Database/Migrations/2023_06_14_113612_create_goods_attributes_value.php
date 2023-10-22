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

class CreateGoodsAttributesValue extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_attributes_value', function (Blueprint $table) {
            $table->unsignedBigInteger('goods_no');
            $table->foreign('goods_no')->references('id')->on('goods')->comment('商品编号');
            $table->bigInteger('attr_no')->comment('商品属性编号');
            $table->string('attr_value_data', 100)->comment('商品属性值');
            $table->comment('产品属性值');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_attributes_value');
    }
}
