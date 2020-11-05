<?php

namespace SeanDowney\BackpackStoreCrud\app\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SeanDowney\BackpackStoreCrud\app\Events\OrderReceived;
use SeanDowney\BackpackStoreCrud\app\Mail\NewOrder;

class SendNewOrderEmail
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
     * @param  Event  $event
     * @return void
     */
    public function handle(OrderReceived $event)
    {
        //
        $order = $event->order;

        Mail::to(config('mail.to'))->send(new NewOrder($order));
    }
}
