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

class CreateOrderPayRecordTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_pay_record', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('订单支付记录');
            $table->string('order_no');
            $table->foreign('order_no')->references('order_no')->on('order_base')->comment('订单唯一号');
            $table->string('pay_trade_no')->default('')->comment('商家支付交易单号');
            $table->decimal('pay_price', 10, 2)->comment('支付金额');
            $table->tinyInteger('pay_type')->default(1)->comment('订单支付类型（1余额支付2支付宝3微信4其他）');
            $table->tinyInteger('pay_status')->default(1)->comment('支付状态（1未支付2支付成功3支付失败4其他原因支付失败）');
            $table->text('pay_params')->nullable()->comment('支付请求参数');
            $table->text('pay_callback_params')->nullable()->comment('支付请求回调参数');
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
        Schema::dropIfExists('order_pay_record');
    }
}
