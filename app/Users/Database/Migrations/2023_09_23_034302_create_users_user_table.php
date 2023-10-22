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

class CreateUsersUserTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_user', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('用户数据表');
            $table->bigIncrements('id')->comment('主键');

            # 帮我生成手机号的迁移代码，手机号唯一
            $table->string('mobile', 11)->unique()->comment('手机号');
            $table->string('email', 100)->nullable()->comment('邮箱');
            $table->string('password', 100)->comment('密码');
            $table->string('nickname', 15)->nullable()->comment('用户昵称');
            $table->string('avatar', 100)->nullable()->comment('用户头像');
            $table->tinyInteger('sex', false, true)->default(0)->comment('用户性别');
            $table->string('real_name', 50)->nullable()->comment('用户真实姓名');
            $table->string('ip', 50)->nullable()->comment('用户新增时候的ip地址');
            $table->string('last_ip', 50)->nullable()->comment('用户上一次登陆的ip地址');
            $table->tinyInteger('sign_in_days', false, true)->default(0)->comment('用户连续签到天数');
            $table->tinyInteger('experience', false, true)->default(0)->comment('用户会员经验进度');
            $table->tinyInteger('status', false, true)->default(0)->comment('用户状态，含（正常，封禁）两种状态');
            $table->tinyInteger('level', false, true)->default(0)->comment('用户会员等级');
            $table->string('invite_code', 50)->nullable()->comment('用户邀请码');
            $table->string('invite_code_by', 50)->nullable()->comment('用户邀请人');

            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();

            $table->index('nickname', 'idx_nickname');
            $table->index('email', 'idx_email');
            $table->index('mobile', 'idx_mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_user');
    }
}
