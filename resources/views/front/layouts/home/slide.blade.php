<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

        @foreach($slides as $slide)

            <div class="carousel-item {{$loop->index==0?'active':''}}">
                <a href="{{$slide->button_link}}">
                    <img class="w-100" src="{{asset($slide->image->path)}}"
                         alt="First slide">
                </a>
            </div>
        @endforeach

    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
       data-slide="next">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button"
       data-slide="prev">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
