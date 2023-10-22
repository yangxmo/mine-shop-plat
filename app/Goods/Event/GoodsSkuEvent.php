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
namespace App\Goods\Event;

use Hyperf\Database\Model\Events\Deleted;
use Hyperf\Database\Model\Events\Updated;

class GoodsSkuEvent
{
    public Updated|Deleted $modelEvent;

    public function __construct(Updated|Deleted $modelEvent)
    {
        $this->modelEvent = $modelEvent;
    }
}
