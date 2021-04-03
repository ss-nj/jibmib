<div class="large-img-container">
    @foreach($takhfif->images as $t_image)
        <img id="{{$t_image->id}}" class="w-100 {{$loop->first?'':'theme-hidden'}}"
             src="{{asset($t_image->path)}}"
             alt="{{$takhfif->name}}">

    @endforeach
</div><!-- .large-img-container -->

<div class="thumbs-img-container pt-4">
    <div class="single-thumb-slider">

        @foreach($takhfif->images as $t_image)

            <div class="single-thumb-container">

                <img id="{{$t_image->id}}" class="single-img-thumb"  src="{{asset($t_image->path)}}"
                     alt="{{$takhfif->name}}">
            </div>
        @endforeach
    </div>


</div><!-- .thumbs-img-container -->
