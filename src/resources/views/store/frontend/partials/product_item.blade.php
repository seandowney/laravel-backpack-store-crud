<div class="col-md-4 img-portfolio">
    @php
        $images = (array)$product->images;
    @endphp
    <a href="{{ url()->current().'/'.$product->slug }}">
        <img class="img-responsive img-hover" src="{{ url('img/'.array_shift($images)) }}?w=370" alt="{{ $product->title }}">
        <h3>
            {{ $product->title }}
        </h3>
    </a>

    @if($product->intro)<p>{{ $product->intro }}</p>@endif

    @if($product->price_from)<p class="post-meta">{{ $product->price_from }}</p>@endif

    <a href="{{ url()->current().'/'.$product->slug }}" class="btn btn-success">See Options</a>
</div>
