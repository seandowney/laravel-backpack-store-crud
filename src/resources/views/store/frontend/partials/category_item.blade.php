<div class="col-md-4 img-portfolio">
    <a href="{{ url(config('seandowney.storecrud.route_prefix', 'store').'/'.$category->slug.'/') }}">
        <img class="img-responsive img-hover" src="{{ url('img/'.$category->image) }}?w=370" alt="{{ $category->title }}">
    </a>
    <h3>
        <a href="{{ url(config('seandowney.storecrud.route_prefix', 'store').'/'.$category->slug.'/') }}">{{ $category->title }}</a>
    </h3>
    @if($category->description){!! $category->description !!}@endif
</div>
