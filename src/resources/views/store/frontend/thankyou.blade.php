@extends('layouts.default')

{{-- Page title --}}
@section('title')
Thank you ::
@parent
@stop


{{-- Page content --}}
@section('content')
<div class="page-title">
  <div class="overlay"></div>
  <h1>Thank you</h1>
</div>

<div class="light-wrapper">
  <div class="container">


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Thank you</h1>

        </div>
    </div>
    <!-- /.row -->

    <div class="row">
      @if (isset($order) and !empty($order->order_num ))
      <p>Thank you for your order, number <b>{{ $order->order_num }}<b>.</p>

      <p>You will receive an email confirming your order to <b>{{ $order->email }}</b>.</p>

      <p>Your reciept can be seen here <a href="{{ $order->receipt_url }}" target="_blank">Stripe Receipt</a>.</p>

      <p>You will receive updates by email as the order progresses.</p>

      <p>Thank you</p>
      @else
      <p>There is currently no valid order.</p>
      <p><a class="btn btn-success float-right" href="/shop">Continue Shopping</a></p>
      @endif
    </div>
  </div>
</div>

@stop
