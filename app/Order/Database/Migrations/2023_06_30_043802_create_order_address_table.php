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

class CreateOrderAddressTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_address', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('订单地址表');
            $table->string('order_no');
            $table->foreign('order_no')->references('order_no')->on('order_base')->comment('订单唯一号');
            $table->string('receive_user_name', 20)->comment('收货人名称');
            $table->string('receive_user_mobile', 20)->comment('收货人手机号号码/座机');
            $table->string('receive_user_province', 20)->comment('收货人所属省份');
            $table->string('receive_user_province_code', 20)->comment('收货人所属省份code');
            $table->string('receive_user_city', 20)->comment('收货人所属市');
            $table->string('receive_user_city_code', 20)->comment('收货人所属市code');
            $table->string('receive_user_street', 20)->comment('收货人所属区');
            $table->string('receive_user_street_code', 20)->comment('收货人所属区code');
            $table->string('receive_user_address', 255)->comment('具体地址');
            $table->string('receive_logistics_type', 20)->default('')->comment('物流类型编号');
            $table->string('receive_logistics_no', 30)->nullable()->comment('物流单号');
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
        Schema::dropIfExists('order_address');
    }
}
