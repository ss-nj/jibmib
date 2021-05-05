@extends('front.layouts.master')

@section('content')

    <article class="w-100">
        <section class="content-container mt-5">

            <!-- _____________Resturant Section_________________________-->
            <div class="w-100 mt-5 mb-5">
                <!-- ______________Resturant Section Title ________________-->
                <div class="w-100">
                    <div class="row">
                        <div class="job-sec-title-text">{{$title}}</div>
                        <div class="col job-sec-title-line"></div>
                    </div>
                    <div class="w-100 pt-3 pl-lg-5">
{{--                        <div class="single-tag-item">همه</div>--}}
{{--                        @foreach($category->categories as $category)--}}
{{--                            <div class="single-tag-item sub-cat-active">{{$category->name}}</div>--}}
{{--                        @endforeach--}}
                    </div>
                </div>

                <!-- ______________home-line-thumb __________________________-->
                <div class="w-100">
                    <div class=" position-relative w-100 row">
                    @foreach($takhfifs as $takhfif)
                        <!-- ______________ Descktop Thumbnail __________________________-->
                            <div class="col-md-3 col-sm-6 col-12 mt-4 thumb-desktop"><a
                                    href="{{route('single',$takhfif->slug)}}">
                                    <div class="job-small-thumb position-relative m-auto">
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
                                                <span>{{\Illuminate\Support\Str::limit($takhfif->shop->address,26)}}</span>
                                            </div>
                                            <div class="col-6 job-small-thumb-rating">
                                                <span><i class="fa-solid fa-eye"></i></span>
                                                <span>بازدید</span>
                                                <span>{{$takhfif->view_count}}</span>
                                            </div>
                                        </div>
                                    </div><!--job-small-thumb-->
                                </a></div>
                            <!-- ______________ Responsive Thumbnail __________________________-->
                            <div class="thumb-responsive w-100 mt-3"><a class="w-100 d-flex" href="{{route('single',$takhfif->slug)}}">
                                    <img class="job-small-thumb-img" src="{{asset($takhfif->images()->count()
?$takhfif->images()->first()->path
:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}" alt="">
                                    <div class="position-relative pt-2 w-100">
                                        <div class="cart-item-title">{{$takhfif->name}}</div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="single-real-price-num">
                                                <span>{{$takhfif->price}}</span>
                                                <span>تومان</span>
                                                <div></div>
                                            </div>
                                            <div class="single-off-price-num">
                                                <span>{{$takhfif->discount_pirce}}</span>
                                                <span>تومان</span>
                                            </div>
                                        </div>
                                        <div class="cart-off-value text-center">{{$takhfif->discount}}%</div>
                                    </div>
                                </a></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="clear-fix"></div>
            {{--      _________________ Banner Section __________________ --}}

{{--            <div class="p-3">--}}
{{--                @foreach($banners as $banner)--}}
{{--                    <a href="{{$banner->banners_url}}"><img class="w-100" src="{{asset($banner->image->path)}}" alt=""></a>--}}
{{--                @endforeach--}}

{{--            </div>--}}

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
