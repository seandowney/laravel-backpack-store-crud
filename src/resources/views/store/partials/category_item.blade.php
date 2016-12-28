<div class="col-md-4 img-portfolio">
    <a href="{{ url('store/category/'.$category->slug) }}">
        <img class="img-responsive img-hover" src="{{ url($category->image) }}" alt="">
    </a>
    <h3>
        <a href="{{ url('store/category/'.$category->slug) }}">{{ $category->title }}</a>
    </h3>
    {!! $category->description !!}
</div>
