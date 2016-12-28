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
                <h1 class="page-header">{{ $title }}</h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
        @foreach ($categories as $category)
            @include('seandowney::store.partials.category_item', ['category' => $category])
        @endforeach
        </div>
@stop
