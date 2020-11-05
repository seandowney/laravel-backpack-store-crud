<?php

namespace SeanDowney\BackpackStoreCrud\app\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SeanDowney\BackpackStoreCrud\app\Events\OrderReceived;
use SeanDowney\BackpackStoreCrud\app\Events\OrderStatusUpdated;
use SeanDowney\BackpackStoreCrud\app\Listeners\SendNewOrderEmail;
use SeanDowney\BackpackStoreCrud\app\Listeners\SendOrderConfirmationEmail;
use SeanDowney\BackpackStoreCrud\app\Listeners\SendOrderUpdatedEmail;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        OrderReceived::class => [
            SendOrderConfirmationEmail::class,
            SendNewOrderEmail::class,
        ],
        OrderStatusUpdated::class => [
            SendOrderUpdatedEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
