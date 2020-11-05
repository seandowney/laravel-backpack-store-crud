<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach($images as $ndx => $display_image)
        <li data-target="#carousel-example-generic" data-slide-to="{{ $ndx }}" @if($loop->first)class="active" @endif></li>
        @endforeach
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach($images as $display_image)
        <div class="item @if($loop->first)active @endif">
            <img class="img-responsive" src="{{ url('/storage/'.$display_image) }}" alt="">
        </div>
        @endforeach
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
