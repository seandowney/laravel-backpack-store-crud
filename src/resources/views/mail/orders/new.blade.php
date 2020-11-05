@component('mail::message')
# Order Received

An order has been placed on {{ config('app.name') }}.

@include('seandowney::mail.orders.partials.order_number')

@include('seandowney::mail.orders.partials.address')

@include('seandowney::mail.orders.partials.order_summary')

@endcomponent