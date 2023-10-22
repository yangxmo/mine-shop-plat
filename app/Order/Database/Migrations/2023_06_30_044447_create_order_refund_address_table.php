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

class CreateOrderRefundAddressTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_refund_address', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('订单退款地址表');

            $table->unsignedBigInteger('refund_order_no');
            $table->foreign('refund_order_no')->references('refund_order_no')->on('order_refund')->comment('订单退款唯一号');

            $table->string('refund_user_name', 20)->comment('退货用户名称');
            $table->string('refund_user_mobile', 20)->comment('退货用户联系方式');
            $table->string('refund_user_address', 50)->comment('退货用户详细地址');
            $table->string('refund_user_logistics_no', 50)->comment('退货用户物流单号');

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
        Schema::dropIfExists('order_refund_address');
    }
}
