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

class CreateGoods extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods', function (Blueprint $table) {
            // 为雪花算法，雪花ID
            $table->bigIncrements('id')->autoIncrement();
            // 商品名称
            $table->string('goods_name', 150)->comment('商品名称');
            // 单价
            $table->char('goods_unit', 5)->default('')->comment('商品单位');
            // 商品关键词
            $table->string('goods_keyword', 100)->default('')->comment('商品关键词');
            // 商品价格
            $table->decimal('goods_price')->default(0.00)->comment('商品建议销售价');
            // 会员价
            $table->decimal('goods_vip_price')->default(0.00)->comment('商品会员价格');
            // 市场价
            $table->decimal('goods_market_price')->default(0.00)->comment('参考价格，返回价格区间，可能为空');
            // 商品库存（无sku时取这里的库存，有sku时取sku的库存）
            $table->bigInteger('goods_sale')->default(0)->comment('商品库存');
            // 商品预警库存
            $table->bigInteger('goods_warn_sale')->default(0)->comment('商品库存');
            // 商品首图
            $table->json('goods_image')->nullable()->comment('商品首图');
            // 商品图片
            $table->json('goods_images')->nullable()->comment('商品图片');
            // 商品视频
            $table->string('goods_video', 255)->nullable()->comment('商品视频');
            // 商品分组
            $table->integer('goods_category_id')->default(0)->comment('分组ID');
            // 商品类型
            $table->enum('goods_type', [1, 2])->default(1)->comment('商品类型（1普通商品2虚拟商品）');
            // 商品规格类型
            $table->enum('goods_spec_type', [1, 2])->default(1)->comment('商品类型（1普通商品2虚拟商品）');
            // 商品状态
            $table->enum('goods_status', [1, 2, 3, 4])->default(1)->comment('商品状态 (1上架2下架3平台下架4作废)');
            // 商品语言
            $table->enum('goods_language', [1, 2])->default(1)->comment('商品语言（1中文2英文）');
            // 商品描述
            $table->text('goods_description')->nullable()->comment('商品详情描述，可包含图片中心的图片URL');
            // 排序
            $table->bigInteger('goods_sort')->unsigned()->default(0)->comment('商品排序');

            $table->datetimes();

            $table->dateTime('deleted_at')->nullable();

            // 索引
            $table->index(['goods_name'], 'idx_name');
            $table->index(['goods_category_id'], 'idx_cid');
            $table->index(['goods_price'], 'idx_price');
            $table->index(['goods_status'], 'idx_status');
            $table->index(['goods_keyword'], 'idx_keyword');
            $table->index(['goods_category_id', 'goods_status'], 'idx_cid_status');

            $table->comment('商品表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
}
