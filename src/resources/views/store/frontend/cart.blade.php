@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{{ $title }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-title">
  <div class="overlay"></div>
  <h1>Shop</h1>
</div>

<div class="light-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 content">
        <h1 class="page-header">Basket</h1>
        <review-cart></review-cart>
      </div>
    </div>
  </div>
</div>
@endsection
