
## Order Summary

@component('mail::table')
| Item       | Qty         | Unit Price  | Subtotal |
| :------------- |:-------------:| --------:| --------:|
@foreach($order->items as $item)
| {{ $item->title }} | {{ $item->quantity }} | {{ $item->price }} | {{ $item->total }} |
@endforeach

|  |  | |
|  --------: | --------:| --------:|
|  | Subtotal | {{ $order->sub_total }} |
|  | Delivery | {{ $order->delivery_cost }} |
|  | Total | {{ $order->total }} |
@endcomponent
