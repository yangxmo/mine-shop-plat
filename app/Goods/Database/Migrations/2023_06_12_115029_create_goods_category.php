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

class CreateGoodsCategory extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_category', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->bigInteger('parent_id')->default(0)->comment('上级ID');
            $table->string('title', '30')->default('')->comment('分组名称');
            $table->bigInteger('feed_count')->default(0)->comment('分组下商品总数');
            $table->tinyInteger('status')->default(1)->comment('分组状态（2无用1有用）');
            $table->integer('sort')->default(1)->comment('分类排序');
            $table->datetimes();
            $table->datetime('deleted_at')->nullable();

            $table->comment('商品分类');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_category');
    }
}
