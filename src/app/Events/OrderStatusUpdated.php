<?php

namespace SeanDowney\BackpackStoreCrud\app\Events;

use Illuminate\Queue\SerializesModels;
use SeanDowney\BackpackStoreCrud\app\Models\Order;

class OrderStatusUpdated
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
