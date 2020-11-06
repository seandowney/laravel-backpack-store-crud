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
<!-- Page Heading/Breadcrumbs -->
<div class="light-wrapper">
    <div class="container">


          <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $product->title }}</h1>

            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-6">
                @include('seandowney::frontend.partials.carousel', ['images' => $images])
            </div>

            <div class="col-md-6">
                @if($options)
                <h3>Select your option</h3>
                <product
                    @if($product->remaining_num) v-bind:remainingnum="{{ $product->remaining_num }}" @endif
                    @if($product->total_num) v-bind:totalnum="{{ (int)$product->total_num }}" @endif
                    productcode="{{ $product->code }}"
                    currency="{{ config('seandowney.storecrud.currency.symbol', '€') }}"
                    v-bind:options="{{ json_encode($options) }}"></product>
                @endif

            </div>

        </div>
        <div class="row">

            <div class="col-lg-12">
                <h3>Description</h3>
                {!! $product->description !!}
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>
@stop
