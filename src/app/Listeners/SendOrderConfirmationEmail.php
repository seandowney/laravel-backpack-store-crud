<?php

namespace SeanDowney\BackpackStoreCrud\app\Listeners;

use SeanDowney\BackpackStoreCrud\app\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SeanDowney\BackpackStoreCrud\app\Events\OrderReceived;

class SendOrderConfirmationEmail
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
     * @param  OrderReceived  $event
     * @return void
     */
    public function handle(OrderReceived $event)
    {
        //
        $order = $event->order;

        Mail::to($order->email)->send(new OrderConfirmed($order));
    }
}
