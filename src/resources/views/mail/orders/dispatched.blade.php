@component('mail::message')
# Order Dispatched

Thank you for your order at {{ config('app.name') }}.

Your package has now been dispatched.

@include('seandowney::mail.orders.partials.order_number')

@include('seandowney::mail.orders.partials.address')

@if(!empty($order->shipping_code))
## Tracking

Your package has been shipped by An Post.

You can track your order using the link below

@component('mail::button', ['url' => 'https://www.anpost.com/Post-Parcels/Track/History?item='.$order->shipping_code, 'color' => 'red'])
Track Order
@endcomponent
@endif

@include('seandowney::mail.orders.partials.order_summary')

Thank you,<br>
Breda
@endcomponent