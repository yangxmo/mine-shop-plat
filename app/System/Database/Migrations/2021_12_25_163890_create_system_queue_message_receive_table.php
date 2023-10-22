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

class CreateSystemQueueMessageReceiveTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_queue_message_receive', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('队列消息接收人表');
            $table->addColumn('bigInteger', 'message_id', ['unsigned' => true, 'comment' => '队列消息主键']);
            $table->addColumn('bigInteger', 'user_id', ['unsigned' => true, 'comment' => '接收用户主键']);
            $table->addColumn('smallInteger', 'read_status', ['default' => 1, 'comment' => '已读状态 (1未读 2已读)'])->nullable();
            $table->primary(['message_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_queue_message_receive');
    }
}
