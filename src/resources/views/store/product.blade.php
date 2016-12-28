@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{{ $title }}} ::
@parent
@stop


{{-- Page content --}}
@section('content')
<!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $product->title }}</h1>

            </div>
        </div>
        <!-- /.row -->

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-8">
                @include('seandowney::store.partials.carousel', ['images' => $images])
            </div>

            <div class="col-md-4">
                <h3>Description</h3>
                {!! $product->description !!}
                @if($product->total_num && $product->remaining_num)
                <p class="post-meta">{{ $product->remaining_num }} remaining of {{ $product->total_num }}</p>
                @endif

                <h3>Options</h3>
                @if($options)
                <ul>
                    @foreach($options as $option)
                    <li><a href="{{ url('/store/purchase/'.$product->slug.'/'.$option->code)}}">{{ $option->title }} - €{{ $option->price }}</a></li>
                    @endforeach
                </ul>
                @endif
                <!-- @if($product->priceOptions)
                <ul>
                    @foreach($product->priceOptions as $option)
                    <li>{{ $option->title }} - €{{ $option->price }}</li>
                    @endforeach
                </ul>
                @endif -->
            </div>

        </div>
        <!-- /.row -->

@stop
