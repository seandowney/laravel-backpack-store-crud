@component('mail::message')
# Order Confirmed

Thank you for your order at {{ config('app.name') }}. Once your package ships we will send you a notification email. Your order confirmation is below. 

@include('seandowney::mail.orders.partials.order_number')

@include('seandowney::mail.orders.partials.address')

@include('seandowney::mail.orders.partials.order_summary')

Thank you,<br>
Breda
@endcomponent