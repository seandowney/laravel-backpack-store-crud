<?php

namespace SeanDowney\BackpackStoreCrud\app\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use SeanDowney\BackpackStoreCrud\app\Models\Order;

class OrderUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $currency;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->currency = config('seandowney.storecrud.currency.symbol');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('seandowney::mail.orders.updated');
    }
}
