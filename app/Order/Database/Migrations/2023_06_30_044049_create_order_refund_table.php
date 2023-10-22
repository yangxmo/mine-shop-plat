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

class CreateOrderRefundTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_refund', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('订单退款表');
            $table->bigInteger('refund_order_no')->index()->unsigned()->unique()->comment('退款单号');

            $table->string('order_no');
            $table->foreign('order_no')->references('order_no')->on('order_base')->comment('订单唯一号');
            $table->string('refund_trade_no', 150)->unique()->comment('退款交易号');
            $table->decimal('refund_price', 10, 2)->comment('退款金额');
            $table->timestamp('refund_apply_time')->nullable()->comment('申请退款时间');
            $table->timestamp('refund_price_time')->nullable()->comment('退款时间');
            $table->tinyInteger('refund_examine_status')->default(1)->comment('退款审核状态（1待审核2审核成功3审核失败）');
            $table->string('refund_examine_fail_msg', 255)->default('')->comment('退款审核失败原因');
            $table->tinyInteger('refund_status')->default(1)->comment('退款状态（1待退款2退款成功3退款失败）');
            $table->tinyInteger('refund_type')->default(2)->comment('退款类型（1部分退款2全部退款）');
            $table->string('refund_order_tenant_no', 20)->comment('所属企业租户');

            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();

            $table->index('refund_order_no', 'idx_refund_order_no');
            $table->index('refund_order_tenant_no', 'idx_refund_order_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_refund');
    }
}
