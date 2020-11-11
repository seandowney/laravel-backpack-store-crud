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


          <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><a href="/shop">Shop</a> - {{ $category->title }}</h1>
                {!! $category->description !!}
            </div>
        </div>
        <!-- /.row -->

        <div class="row product-list">
        @foreach ($products as $product)
            @include('seandowney::frontend.partials.product_item', ['product' => $product])
        @endforeach
        </div>
    </div>
</div>
@stop
