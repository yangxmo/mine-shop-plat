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
namespace App\System\Queue\Consumer;

use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Result;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * 后台内部消息队列消费处理.
 */
 #[Consumer(exchange: "mineadmin", routingKey: "message.routing", queue: "message.queue", name: "message.queue", nums: 1)]
class MessageConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): string
    {
        return parent::consumeMessage($data, $message);
    }

    public function consume($data): string
    {
        return empty($data) ? Result::DROP : Result::ACK;
    }

    /**
     * 设置是否启动amqp.
     */
    public function isEnable(): bool
    {
        return env('AMQP_ENABLE', false);
    }
}
