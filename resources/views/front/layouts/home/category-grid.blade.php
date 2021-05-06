<div class="col-md-6 pt-5">
    <div class="job-big-thumb position-relative">
        <a href="{{route('single',$home_categories[$cat]->takhfifs[$takh]->slug)}}">
            <img class="job-big-thumb-img"
                 src="{{asset($home_categories[$cat]->takhfifs[$takh]->images()->count()
?$home_categories[$cat]->takhfifs[$takh]->images()->first()->path
:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                 alt="{{$home_categories[$cat]->takhfifs[$takh]->name}}">
        </a>
        <div class="thumb-timer text-center">
            @include('front.layouts.timer',['timer_takhfif'=>$home_categories[$cat]->takhfifs[$takh]])
        </div><!--thumb-timer-->
        <div class="job-big-thumb-off">{{$home_categories[$cat]->takhfifs[$takh]->discount}}%</div>
        <div class="row w-100 p-3">
            <div class="job-big-thumb-title">{{$home_categories[$cat]->takhfifs[$takh]->name}}</div>
            <div class="col">
                <div class="job-big-thumb-add-cart float-right mt-3"><a
                        href="{{route('single',$home_categories[$cat]->takhfifs[$takh]->slug)}}"> مشاهده و خرید</a>
                </div>
            </div>
        </div>
        <div class="row w-100 job-big-thumb-status">
            <div class="col-5 job-big-thumb-location">
                <span><i class="fa-solid fa-location-dot"></i></span>
                <span>{{\Illuminate\Support\Str::limit($home_categories[$cat]->takhfifs[$takh]->shop->address,20)}}</span>
            </div>
            <div class="col-7 job-big-thumb-rating">
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span>5.0/5</span>
                <span>(از مجموع</span>
                <span>8</span>
                <span>رای)</span>
                <span> | </span>
                <span><i class="fa-solid fa-eye"></i></span>
                <span>بازدید</span>
                <span>{{$home_categories[$cat]->takhfifs[$takh]->view_count}}</span>
            </div>
        </div>
    </div><!--job-big-thumb-->
</div>
<div class="col-md-6 pt-4">
    <div class="row home-scrole-section">
        @php($i=0)
        @foreach($home_categories[$cat]->takhfifs as $takhfif )
            @php($i++)
             @if($i>=5)
                 @break
            @endif
            <div class="col-sm-6">
                <a href="{{route('single',$takhfif->slug)}}">
                    <div class="job-small-thumb position-relative">
                        <img class="job-small-thumb-img"
                             src="{{asset($takhfif->images()->count()
?$takhfif->images()->first()->path
:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                             alt="{{$takhfif->name}}">
                        <div class="thumb-timer text-center">
                            @include('front.layouts.timer',['timer_takhfif'=>$takhfif])
                        </div><!--thumb-timer-->
                        <div class="job-small-thumb-off">{{$takhfif->discount}}%
                        </div>
                        <div class="row w-100 pt-1">
                            <div
                                class="job-big-thumb-title">{{$takhfif->name}}</div>
                        </div>
                        <div class="row w-100 job-big-thumb-status">
                            <div class="col-6 job-small-thumb-location">
                                <span><i class="fa-solid fa-location-dot"></i></span>
                                <span>{{\Illuminate\Support\Str::limit($takhfif->shop->address,20)}}</span>
                            </div>
                            <div class="col-6 job-small-thumb-rating">
                                <span><i class="fa-solid fa-eye"></i></span>
                                <span>بازدید</span>
                                <span>{{$takhfif->view_count}}</span>
                            </div>
                        </div>
                    </div><!--job-small-thumb-->

                </a>
            </div><!--col-sm-6-->
        @endforeach
    </div><!--row-->
</div>
