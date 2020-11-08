@component('mail::message')
# Order Received

An order has been placed on {{ config('app.name') }}.

@include('seandowney::mail.orders.partials.order_number')

@include('seandowney::mail.orders.partials.address')

@include('seandowney::mail.orders.partials.order_summary')

@component('mail::button', ['url' => secure_url(config('backpack.base.route_prefix', 'admin').'/'.config('seandowney.storecrud.route_prefix', 'store').'/order/'.$order->id.'/edit'), 'color' => 'red'])
View Order
@endcomponent
@endcomponent