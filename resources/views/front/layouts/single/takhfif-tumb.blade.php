<div class="off-thumb-slider">
    @foreach( $s_takhfifs as $s_takhfif)
        <div>
                <a href="{{route('single',$s_takhfif->slug)}}">
                    <div class="job-small-inner-thumb position-relative">
                        <img class="job-small-thumb-img" src="{{asset($s_takhfif->images()->count()
?$s_takhfif->images()->first()->path
:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}" alt="">
                        <div class="thumb-timer text-center">
                            @include('front.layouts.timer',['timer_takhfif'=>$s_takhfif])
                        </div><!--thumb-timer-->
                        <div class="job-small-thumb-off">{{$s_takhfif->discount}}%</div>
                        <div class="row w-100 pt-1">
                            <div class="job-big-thumb-title">{{$s_takhfif->name}}</div>
                        </div>
                        <div class="row w-100 job-big-thumb-status">
                            <div class="col-6 job-small-thumb-location">
                                <span><i class="fa-solid fa-location-dot"></i></span>
                                <span>{{\Illuminate\Support\Str::limit($s_takhfif->shop->address,20)}} </span>
                            </div>
                            <div class="col-6 job-small-thumb-rating">
                                <span><i class="fa-solid fa-eye"></i></span>
                                <span>بازدید</span>
                                <span>{{$s_takhfif->view_count}}</span>
                            </div>
                        </div>
                    </div><!--job-small-thumb-->
                </a>
        </div>
    @endforeach
</div>
