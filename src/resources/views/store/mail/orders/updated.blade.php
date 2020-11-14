@component('mail::message')
# Order Updated

Thank you for your order at {{ config('app.name') }}.

Your order status has been updated to: **{{ config('seandowney.storecrud.order_statuses')[$order->status] }}**.

@include('seandowney::mail.orders.partials.order_number')

@include('seandowney::mail.orders.partials.address')

@include('seandowney::mail.orders.partials.order_summary')

Thank you,<br>
Breda
@endcomponent
