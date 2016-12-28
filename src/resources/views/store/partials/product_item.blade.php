<div class="col-md-4 img-portfolio">
    <a href="{{ url('store/product/'.$product->slug) }}">
        <img class="img-responsive img-hover" src="{{ url('uploads/'.$product->images[0]) }}" alt="">
    </a>
    <h3>
        <a href="{{ url('store/product/'.$product->slug) }}">{{ $product->title }}</a>
    </h3>
    {!! $product->description !!}
    @if($product->total_num && $product->remaining_num)
    <p class="post-meta">{{ $product->remaining_num }} left</p>
    @endif
    @if($product->price_from)From €{{ $product->price_from }}@endif
</div>
