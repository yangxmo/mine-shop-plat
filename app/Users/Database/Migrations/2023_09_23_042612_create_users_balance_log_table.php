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

class CreateUsersBalanceLogTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_balance_log', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('表注释');
            $table->bigIncrements('id')->comment('主键');

            $table->bigInteger('user_id')->comment('用户ID');
            #生成迁移代码，含用户交易类型，交易金额，交易状态，交易前余额，交易后余额，交易时间，交易备注
            $table->enum('type', [1, 2, 3, 4, 5, 6])->comment('交易类型(1:充值,2:提现,3:转账,4:退款,5:扣款,6:系统)');
            $table->decimal('amount', 10, 2)->comment('交易金额');
            $table->enum('status', [1, 2, 3])->default(3)->comment('交易状态(1:成功,2:失败,3:处理中');
            $table->decimal('before_balance', 10, 2)->comment('交易前余额');
            $table->decimal('after_balance', 10, 2)->comment('交易后余额');
            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_balance_log');
    }
}
