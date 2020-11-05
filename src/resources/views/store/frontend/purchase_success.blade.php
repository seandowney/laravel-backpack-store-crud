@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{{ $title }}} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $product->title }}</h1>

    </div>
</div>
<!-- /.row -->

<!-- Portfolio Item Row -->
<div class="row">
Thanks
</div>
@stop
