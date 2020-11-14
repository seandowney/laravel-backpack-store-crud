
## Order Summary

@component('mail::table')
| Item       | Qty         | Unit Price  | Subtotal |
| :------------- |:-------------:| --------:| --------:|
@foreach($order->items as $item)
| {{ $item->title }} | {{ $item->quantity }} | {{ $currency }}{{ $item->price }} | {{ $currency }}{{ $item->total }} |
@endforeach

|  |  | |
|  --------: | --------:| --------:|
|  | Subtotal | {{ $currency }}{{ $order->sub_total }} |
|  | Delivery | {{ $currency }}{{ $order->delivery_cost }} |
|  | Total | {{ $currency }}{{ $order->total }} |
@endcomponent
