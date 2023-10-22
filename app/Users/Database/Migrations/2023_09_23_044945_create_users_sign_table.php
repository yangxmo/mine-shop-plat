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

class CreateUsersSignTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_sign', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('用户签到表');
            $table->bigIncrements('id')->comment('主键');

            $table->bigInteger('user_id')->comment('用户ID');
            $table->timestamp('sign_at')->comment('签到时间');
            $table->integer('sign_days')->default(0)->comment('签到天数');
            $table->string('sign_note')->default('签到')->comment('签到说明');

            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_sign');
    }
}
