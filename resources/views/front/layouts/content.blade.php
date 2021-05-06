<article class="w-100 position-relative">
    <section class="content-container mt-5">
        <div class="row">
            <!-- _______________Category__________________________-->
            <div class="col-md-3 home-cat-container">
                @include('front.layouts.side-menu')
            </div><!--col-md-3-->
            <!-- _______________Slider__________________________-->
            <div class="col-md-6">
                <div class="slider-container w-100">
                    @include('front.layouts.home.slide')
                </div><!--slider-container-->

            </div><!--col-md-6-->
            <!-- _______________Product Top Side__________________________-->
            <div class="col-md-3">
                <!-- ______________Thumbs __________________________-->
                @foreach($vip_takhfifs  as $vip_takhfif)
                    <a href="{{route('single',$vip_takhfif->slug)}}">
                        <div class="home-top-thumb-side position-relative
                        @if($loop->index == 0)
                        mt-0
                        @endif"
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
        <div class="col-12 margin-content-fit">
            <div class="line-thumb-slide position-relative" dir="ltr">
                @foreach($categories as $top_cat)
                    <div class="col-md col-sm-4 col-12">
                        <a href="{{route('category',['city'=>$selected_city,'cat'=>$top_cat->slug])}}">
                            <div class="home-line-thumb position-relative"
                                 style="background-image: url({{asset($top_cat->image->path)}});">
                                <div
                                    class="home-line-thumb-off">{{sprintf('تخفیف تا %s درصد',$top_cat->discount)}}</div>
                            </div><!--home-line-thumb-->
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        @for( $i=0; $i <= 4; $i++)
            @if(isset($home_categories[$i]))
                {{--         ______________Category Section __________________________--}}
                <div class="col-12 mt-5 mb-5">
                    <div class="row">
                        <!-- ______________Category Section Title ________________-->
                        <div class="col-12">
                            <div class="row">
                                <div class="job-sec-title-text">{{$home_categories[$i]->name}}</div>
                                <div class="col job-sec-title-line"></div>
                            </div>
                        </div>

                        <!-- ______________Category Section content ________________-->
                        @if($home_categories[$i]->takhfifs->count()!=0)
                            @include('front.layouts.home.category-grid',['cat'=>$i,'takh'=>0])
                        @endif
                    </div>
                </div>
            @endif
            @if(isset($home_banner[$i]))

                <div class="p-3">
                    {{--      _________________ Banner Section __________________ --}}
                    @include('front.layouts.home.banner-grid',['no'=>$i])
                </div>
            @endif

        @endfor


        <?php //____________________ Bottom Slider _______________________ ?>
        <div class="w-100 pt-5 pb-5 pl-3 pr-3">
            <div class="center position-relative" dir="ltr">

                @include('front.layouts.logo-bar')
            </div>
        </div>

        <?php //____________________ News Letter _______________________ ?>

        @include('front.layouts.mail')


    </section><!--content-container-->
</article>
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
