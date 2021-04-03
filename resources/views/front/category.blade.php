@extends('front.layouts.master')

@section('content')

    <article class="w-100">
        <section class="content-container mt-5">
            <div class="row">
                <!-- _______________Category__________________________-->
                <!-- _______________Category__________________________-->
                <div class="col-md-3 home-cat-container ">
                    @include('front.layouts.side-menu')
                </div><!--col-md-3-->
                <!-- _______________Slider__________________________-->
                <div class="col-lg-6 col-md-8">
                    <div class="slider-container w-100">
                        @include('front.layouts.home.slide')
                    </div><!--slider-container-->

                </div><!--col-md-6-->
                <!-- _______________Product Top Side__________________________-->
                <div class="col-lg-3 col-md-4 home-top-thumbs">
                    <!-- ______________Thumbs __________________________-->
                    @foreach($vip_takhfifs as $vip_takhfif)
                        <a href="{{route('single',$vip_takhfif->slug)}}">
                            <div class="home-top-thumb-side position-relative"
                                 style="background-image: url({{asset($vip_takhfif->images()->count()?$vip_takhfif->images()->first()->path:'')}});">
                                <div class="thumb-timer text-center">
                                    @include('front.layouts.timer',['timer_takhfif'=>$vip_takhfif])

                                </div><!--thumb-timer-->
                                <div class="thumb-add-to-cart text-center">
                                    <div><span>خرید</span><span><i class="fa-regular fa-angle-left"></i></span></div>
                                </div><!--thumb-add-to-cart-->
                            </div><!--home-top-thumb-side-->
                        </a>
                    @endforeach

                </div><!--col-md-3-->
            </div>

            <!-- ______________home-line-thumb __________________________-->
            @php($n=0)
            @foreach( $takhfifs->chunk(8) as $takhfif_group )
                <div class="col-12 mt-5">
                    <div id="line-slider-{{$n}}" class="line-slider position-relative">
                        @foreach($takhfif_group as $takhfif)
                            <div >
                                    <a href="{{route('single',$takhfif->slug)}}">
                                        <div class="job-small-inner-thumb position-relative">
                                            <img class="job-small-thumb-img" src="{{asset($takhfif->images()->count()
?$takhfif->images()->first()->path
:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}" alt="">
                                            <div class="thumb-timer text-center">
                                                @include('front.layouts.timer',['timer_takhfif'=>$takhfif])
                                            </div><!--thumb-timer-->
                                            <div class="job-small-thumb-off">{{$takhfif->discount}}%</div>
                                            <div class="row w-100 pt-1">
                                                <div class="job-big-thumb-title">{{$takhfif->name}}</div>
                                            </div>
                                            <div class="row w-100 job-big-thumb-status">
                                                <div class="col-6 job-small-thumb-location">
                                                    <span><i class="fa-solid fa-location-dot"></i></span>
                                                    <span>{{\Illuminate\Support\Str::limit($takhfif->shop->address,20)}} </span>
                                                </div>
                                                <div class="col-6 job-small-thumb-rating">
                                                    <span><i class="fa-solid fa-eye"></i></span>
                                                    <span>بازدید</span>
                                                    <span>{{$takhfif->view_count}}</span>
                                                </div>
                                            </div>
                                        </div><!--job-small-thumb-->
                                    </a>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="p-3">
                    @if($banners[ $n ])
                        <a href="{{$banners[ $n]->banners_url}}">
                            <img class="w-100"
                                 src="{{asset($banners[ $n ]->image->path)}}"
                                 alt="">
                        </a>
                    @else
{{--                        <a href="#"><img class="w-100" src="{{asset($path_user.'img//home-banner-1.png').'?ver='.$ver}}"--}}
{{--                                         alt=""></a>--}}
                    @endif
                </div>
                @php($n++)
            @endforeach

            @for( $i=$n; $i <= 3; $i++)
                @if($banners[ $i ])
                    <a href="{{$banners[ $i]->banners_url}}">
                        <img class="w-100"
                             src="{{asset($banners[ $i ]->image->path)}}"
                             alt="">
                    </a>
                @else
{{--                    <a href="#"><img class="w-100" src="{{asset($path_user.'img//home-banner-1.png').'?ver='.$ver}}"--}}
{{--                                     alt=""></a>--}}
                @endif
            @endfor



            <?php //____________________ Bottom Slider _______________________ ?>
            <div class="w-100 pt-5 pb-5 pl-3 pr-3">
                <div class="center position-relative" dir="ltr">

                    @include('front.layouts.logo-bar')

                </div>
            </div>
            @include('front.layouts.mail')

        </section><!--content-container-->
    </article>

@endsection

@push('style')
    <style>
        .carousel-item img {
            height: 339px !important;
        }
    </style>
@endpush

@push('internal_js')
    <script>

        $(document).ready(function () {
            var timers = $('.timer');
            timers.each(function () {
                let timer = $(this);
                let seconds = timer.attr('data-seconds');
                timer.backward_timer({
                    seconds: seconds
                })
            })
            timers.backward_timer('start')

        });

    </script>
@endpush
