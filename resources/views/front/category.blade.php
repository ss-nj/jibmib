@extends('front.layouts.master')

@section('content')

    <article class="w-100">
        <section class="content-container mt-5">
            <div class="row">
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
                @if($vip_takhfif)
                    <div class="col-lg-3 col-md-4 special-offer-side">
                        <div class="card-section w-100 mt-1 p-2 pt-4 sp-offer">
                            <div class="pl-5 f-size-2">
                                <span><i class="fa-solid fa-fork-knife"></i></span>
                                <span>{{$vip_takhfif->shop->shop_name}}</span>
                            </div>
                            <h3 class="mt-3">{{$vip_takhfif->name}}</h3>
                            <div class="d-flex justify-content-between w-100">
                                <div class=" pt-3 pb-3 pr-3 text-success">
                                    <span class="pr-2"><i class="fa-solid fa-location-dot"></i></span>
                                    <span> {{\Illuminate\Support\Str::limit($vip_takhfif->address,30)}} </span>
                                </div>
                                <div class="pt-3 pl-3">
                                    <span class="pr-2"><i class="fas fa-shopping-cart"></i></span>
                                    <span> 1630 </span><span> خرید</span>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="align-self-center">
                                    <div class="single-real-price-num">
                                        <span>{{number_format($vip_takhfif->price)}}</span>
                                        <span>تومان</span>
                                        <div></div>
                                    </div>
                                    <div class="single-off-price-num mt-4">
                                        <span>{{number_format($vip_takhfif->discount_price)}}</span>
                                        <span>تومان</span>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="theme-circle bg-danger text-white align-self-center d-flex flex-column justify-content-center align-items-center">
                                        <div class="f-size-3">{{$vip_takhfif->discount}}%</div>
                                        <div class="f-size-1">تخفیف</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="cat-spe-add-cart">


                                <a href="{{route('single',$vip_takhfif->slug)}}"
                                   class="single-add-cart orange-btn mt-4">
                                    مشاهده و خرید
                                </a>
                            </div>
                        </div>
                        <!-- ______________Thumbs __________________________-->

                    </div><!--col-md-3-->
                @endif
            </div>

            <!-- _____________Resturant Section_________________________-->
            <div class="w-100 mt-5 mb-5">
                <!-- ______________Resturant Section Title ________________-->
                <div class="w-100">
                    <div class="row">
                        <div class="job-sec-title-text">{{$category->name}}</div>
                        <div class="col job-sec-title-line"></div>
                    </div>
                    <div class="w-100 pt-3 pl-lg-5">
                        <a href="{{route('category',['city'=>$selected_city,'cat'=>$category->slug])}}">
                            <div class="single-tag-item sub-cat-active">همه</div>
                        </a>
                        @foreach($category->categories as $subCategory)
                            <a href="{{route('category',['city'=>$selected_city,'cat'=>$subCategory->slug])}}">
                                <div class="single-tag-item">{{$subCategory->name}}</div>
                            </a>
                        @endforeach
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

            <div class="p-3">
                @foreach($banners as $banner)
                    <a href="{{$banner->banners_url}}"><img class="w-100" src="{{asset($banner->image->path)}}" alt=""></a>
                @endforeach

            </div>

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
