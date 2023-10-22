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

class CreateTenantTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenant', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('租户表');
            $table->bigIncrements('id')->comment('主键');
            $table->string('tenant_id', 20)->comment('企业编码');
            $table->string('tenant_name', 50)->comment('企业名称');
            $table->string('tenant_logo', 100)->default('')->comment('企业logo');
            $table->tinyInteger('audit')->default(1)->comment('审核 1待审核，2审核成功，3审核失败');
            $table->timestamp('expiration_at')->nullable()->comment('有效期');
            $table->string('corporation_name', 30)->default('')->comment('法人姓名');
            $table->tinyInteger('sex')->default(0)->comment('法人性别 0未知 1男 2女');
            $table->char('id_card', 18)->default('')->comment('身份证号');
            $table->string('card_front', 100)->default('')->comment('身份证正面');
            $table->string('card_back', 100)->default('')->comment('身份证背面');
            $table->timestamp('expiration_start')->nullable()->comment('身份证有效期开始日期');
            $table->timestamp('expiration_end')->nullable()->comment('身份证有效期结束日期');
            $table->timestamp('auth_at')->nullable()->comment('认证时间');
            $table->string('corporate_name', 100)->default('')->comment('公司名称');
            $table->string('usci', 25)->default('')->comment('统一社会信息代码');
            $table->string('business_license', 100)->default('')->comment('营业执照');
            $table->string('term', 30)->default('')->comment('经营期限');
            $table->string('address', 100)->default('')->comment('经营地址');
            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();

            $table->index(['tenant_id'], 'idx_tenant_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant');
    }
}
