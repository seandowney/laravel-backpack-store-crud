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
                <h1 class="page-header"></h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row product-list">
        @foreach ($categories as $category)
            @include('seandowney::frontend.partials.category_item', ['category' => $category])
        @endforeach
        </div>

    </div>
</div>
@stop
