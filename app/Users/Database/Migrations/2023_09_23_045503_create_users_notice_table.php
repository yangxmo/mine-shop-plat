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

class CreateUsersNoticeTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_notice', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('用户通知表');
            $table->bigIncrements('id')->comment('主键');
            $table->bigInteger('user_id')->comment('用户ID');

            $table->json('user_ids')->comment('接收消息的用户IDs');
            $table->enum('notice_type', [1, 2])->comment('通知类型（1系统消息，2用户消息)');
            $table->bigInteger('send_user', false, true)->comment('发送人');
            $table->string('title', 255)->comment('通知消息的标题');
            $table->json('content')->nullable()->comment('消息的内容json');
            $table->timestamp('send_time')->comment('发送时间');
            $table->enum('status', [1, 2])->comment('发送状态');
            $table->timestamp('real_send_time')->nullable()->comment('实际发送时间');
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
        Schema::dropIfExists('users_notice');
    }
}
