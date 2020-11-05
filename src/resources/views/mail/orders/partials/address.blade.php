## Shipping To

{{ $order->name }}<br>
@if(!empty($order->address)){{ $order->address }}<br> @endif
@if(!empty($order->city)){{ $order->city }}<br> @endif
@if(!empty($order->state)){{ $order->state }}<br> @endif
@if(!empty($order->postcode)){{ $order->postcode }}<br> @endif
@if(!empty($order->country)){{ $order->country }}<br> @endif
@if(!empty($order->phone)){{ $order->phone }}<br> @endif
