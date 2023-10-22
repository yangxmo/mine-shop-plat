<?php

namespace App\Order\Event;

use App\Order\Model\OrderBase;

class OrderUpdateStatusEvent
{
    public int $orderNo;
    public int $status;

    public function __construct(int $orderNo, int $status)
    {
        $this->orderNo = $orderNo;
        $this->status = $status;
    }

    public function getOrderNo(): int
    {
        return $this->orderNo;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}