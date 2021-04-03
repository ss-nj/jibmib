@foreach($logos as $logo)
    <!-- <div> -->
    <div class="home-slider-thumb">
        <img src="{{asset($logo->path)}}" alt="">
    </div>
    <!-- </div> -->
@endforeach


