<?php

namespace SeanDowney\BackpackStoreCrud\app\Listeners;

use SeanDowney\BackpackStoreCrud\app\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SeanDowney\BackpackStoreCrud\app\Events\OrderReceived;
use SeanDowney\BackpackStoreCrud\app\Events\OrderStatusUpdated;
use SeanDowney\BackpackStoreCrud\app\Mail\OrderDispatched;
use SeanDowney\BackpackStoreCrud\app\Mail\OrderUpdated;

class SendOrderUpdatedEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderStatusUpdated  $event
     * @return void
     */
    public function handle(OrderStatusUpdated $event)
    {
        $order = $event->order;

        if ($order->isDispatched()) {
            Mail::to($order->email)->send(new OrderDispatched($order));
        } elseif ($order->isProcessing()) {
            Mail::to($order->email)->send(new OrderUpdated($order));
        }
    }
}
