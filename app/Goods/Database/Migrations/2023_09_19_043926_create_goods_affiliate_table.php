<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateGoodsAffiliateTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_affiliate', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('商品附属信息');
            $table->bigIncrements('id')->comment('主键');

            // 商品ID
            $table->bigInteger('goods_no')->comment('商品ID');
            // 是否预售
            $table->enum('goods_is_presell', [1, 2])->default(1)->comment('是否预售商品（1否2是）');
            // 是否限购
            $table->enum('goods_is_purchase', [1, 2])->default(1)->comment('是否限购商品（1否2是）');
            // 限购类型
            $table->enum('goods_purchase_type', [1, 2])->default(1)->comment('限购商品类型（1单次限购2全部限购）');
            // 限购数量
            $table->bigInteger('goods_purchase_num')->default(0)->comment('限购商品数量');
            // 付费会员专属
            $table->enum('goods_is_vip', [1, 2])->default(1)->comment('是否会员商品（1否2是）');
            // 购买送积分
            $table->bigInteger('goods_buy_point')->default(0)->comment('商品购买送积分');
            // 已售数量
            $table->bigInteger('goods_sales')->default(0)->comment('商品已售数量');
            // 商品单位
            $table->char('goods_unit', 1)->default('件')->comment('商品单位');
            // 物流方式
            $table->enum('goods_logistics_type', [1, 2])->nullable()->comment('商品物流方式，（1物流2到店核销）');
            // 运费方式
            $table->enum('goods_freight_type', [1, 2])->nullable()->comment('商品运费方式，（1固定邮费2运费模板）');
            // 商品推荐
            $table->char('goods_recommend', 10)->default('')->comment('商品推荐');

            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();

            $table->index('goods_no', 'idx_goods_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('goods_affiliate');
    }
}
