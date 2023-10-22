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

class CreateOrderBaseTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_base', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('订单基础表');
            $table->bigIncrements('id')->comment('主键');

            $table->string('order_no', 30)->unique()->comment('订单唯一号');
            $table->decimal('order_price', 10, 2)->default(0.00)->comment('订单总金额');
            $table->decimal('order_discount_price', 10, 2)->default(0.00)->comment('订单优惠金额');
            $table->decimal('order_freight_price', 10, 2)->default(0.00)->comment('订单运费金额');
            $table->decimal('order_pay_price', 10, 2)->default(0.00)->comment('订单实际支付金额');

            $table->timestamp('order_pay_time')->nullable()->comment('订单支付时间');
            $table->timestamp('order_cancel_time')->nullable()->comment('订单关闭时间');
            $table->bigInteger('order_create_user_id')->comment('订单创建用户ID');

            $table->tinyInteger('order_status')->default(1)->comment('订单状态（1正常2用户取消3系统取消4待发货5待收货6订单完成7卖家取消8运营商取消）');
            $table->tinyInteger('order_pay_status')->default(1)->comment('订单支付状态（1待支付2支付成功）');
            $table->tinyInteger('order_refund_status')->default(1)->comment('订单退款状态（1无2审核中3审核成功4审核失败5部分退款成功6全商品退款成功7退款失败）');
            $table->tinyInteger('order_pay_type')->default(1)->comment('订单支付类型（1余额支付2支付宝3微信4其他）');

            $table->string('order_remark')->default('')->comment('订单备注');

            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();

            // 订单号
            $table->index('order_no', 'idx_order_no');
            // 企业下指定用户所有订单
            $table->index(['order_create_user_id'], 'idx_user_id');
            // 企业下用户订单状态
            $table->index(['order_create_user_id', 'order_status'], 'idx_user_status');
            // 企业下用户订单支付状态
            $table->index(['order_create_user_id', 'order_pay_status'], 'idx_user_pay_status');
            // 企业下用户订单退款状态
            $table->index(['order_create_user_id', 'order_refund_status'], 'idx_user_refund_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_base');
    }
}
