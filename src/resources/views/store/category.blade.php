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
                <h1 class="page-header">{{ $category->title }}</h1>
                {!! $category->description !!}
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
        @foreach ($products as $product)
            @include('seandowney::store.partials.product_item', ['product' => $product])
        @endforeach
        </div>
@stop
