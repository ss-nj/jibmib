@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="content-container mt-5">

            <?php //________________ Product Summery ________________________?>
            <div class="product-summery card-section row m-4 position-relative">
                <div class="after-product-summery"></div>
                <div class="job-big-thumb-off">{{$takhfif->discount}}%</div>
                <div class="col-lg-4">
                    @include('front.layouts.single.image-slider',['takhfif'=>$takhfif])
                </div><!-- .col-lg-4 -->
                <div class="col-lg-8">
                    <div class="product-summery-content">
                        <div class="single-title pt-3"><h1>{{$takhfif->name}}</h1></div>
                        <div class="single-content">
                            <div class="d-flex pt-4">
                                <div class="title pr-4">توضیحات</div>
                                <div class="text-justify">
                                    <p>
                                        {!! $takhfif->description !!}
                                    </p>
                                </div>
                            </div><!-- single-content -->
                            <div class="price-container pt-5 position-relative">
                                <div class="row">
                                    <div class="col-sm-6 pt-4">
                                        <div class="d-flex">
                                            <div>ارزش واقعی:</div>
                                            <div class="single-real-price-num">
                                                <span>{{number_format($takhfif->price)}}</span>
                                                <span>تومان</span>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 pt-4">
                                        <div class="d-flex">
                                            <div>پرداخت شما:</div>
                                            <div class="single-off-price-num">
                                                <span>{{number_format($takhfif->discount_price)}}</span>
                                                <span>تومان</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="single-btn-container">
                                        <div class="single-product-num">
                                            <select name="product-num" id="count">
                                                <?php for($i = 1; $i <= 100; $i++): $select = ($i == 1) ? 'selected' : '' ?>
                                                <option
                                                    value="<?php echo $i; ?>" <?php echo $select ?>><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div id="add-to-cart" class="single-add-cart orange-btn mt-4" data-id="{{$takhfif->id}}">
                                            خرید
                                        </div>
                                    </div><!-- .single-btn-container -->

                                </div>
                            </div><!-- .price-container -->
                        </div>
                    </div><!-- .product-summery-content -->
                    <div class="w-100 job-sec-title-line"></div>
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-4 pt-3">
                                <span class="pr-2"><i class="fa-solid fa-location-dot"></i></span>
                                <span>آدرس</span>
                            </div>
                            <div class="col-sm-8 text-right pt-3">
                                {{$takhfif->address}}
                            </div>

                            <div class="col-sm-4 pt-3">
                                <span class="pr-2"><i class="fa-regular fa-clock"></i></span>
                                <span>زمان باقیمانده</span>
                            </div>
                            <div class="col-sm-8 text-right pt-3 ornage-txt">
                                @if($takhfif->display_end_time>now())
                                    <span id='timer_0' data-seconds=" {{$takhfif->display_end_time->diffInSeconds(now())}}"
                                          class='timer'>
     </span>
                                @else
                                    <span id='timer_0'>گذشته</span>
                                @endif
                            </div>

                            <div class="col-sm-4 pt-3">
                                <span class="pr-2"><i class="fa-regular fa-share-nodes"></i></span>
                                <span>اشتراک  با دوستان</span>
                            </div>
                            <div class="single-social-share col-sm-8 text-right pt-3 green-txt">
                                <span><i class="fa-brands fa-telegram-plane"></i></span>
                                <span><i class="fa-brands fa-facebook-square"></i></span>
                                <span><i class="fa-brands fa-twitter-square"></i></span>
                                <span><i class="fa-brands fa-whatsapp-square"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- product-summery -->

            <?php //________________ Product Status ________________________?>
            <div class="single-status card-section w-100 mt-5 pt-4 mb-5">
                <div class="row">
                    <div class="col-md-6">{{$takhfif->shop->shop_name}}</div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div>
                                <span>200</span>
                                <span><i class="fa-solid fa-message"></i></span>
                            </div>
                            <div>
                                <span>200</span>
                                <span><i class="fa-solid fa-heart"></i></span>
                            </div>
                            <div>
                                <?php
                                for($i = 1; $i <= 5; $i++):
                                $color = ($i <= 2) ? '#FFD229' : '#c4c3c3'; ?>
                                <span style="color:<?php echo $color ?>"><i class="fa-solid fa-star"></i></span>
                                <?php endfor; ?>
                                <span>5.0/5</span>
                                <span>(از مجموع</span>
                                <span>8</span>
                                <span>رای)</span>
                            </div>
                            <div>
                                <span class="text-success"><i class="fa-solid fa-eye"></i></span>
                                <span>بازدید</span>
                                <span>{{$takhfif->view_count}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 job-sec-title-line ml-4 mr-4"></div>

                    <div class="col-md-6 pt-3 pb-3 text-success">
                        <span class="pr-2"><i class="fa-solid fa-location-dot"></i></span>
                        <span>{{$takhfif->shop->address}}</span>
                    </div>
                    <div class="col-md-6"></div>
                </div>

            </div>

            <?php //________________ Product Specification ________________________?>
            <div class="w-100">
                <div class="row product-spec mb-3">
                    <div class="col-lg-6">
                        <div class="w-100 h-100 card-section p-3">
                            <div class="title">ویژگی ها</div>
                            <div class="content pt-4 pl-5">
                                <ul>
                                    @foreach($takhfif->parameters as $parameter)
                                        <li class="pb-2"><span><i
                                                    class="fa-solid fa-circle"></i></span> {{$parameter->value}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="w-100 h-100 card-section p-3 mb-3">
                            <div class="title"> شرایط استفاده</div>
                            <div class="content pt-4 pl-5">
                                <ul>
                                    @foreach($takhfif->terms as $term)
                                        <li class="pb-2"><span><i
                                                    class="fa-solid fa-circle"></i></span> {{$term->value}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php //________________ Map Section ________________________?>
            <div class="mb-5">
                <div class="contact-map-container position-relative ">
                    <div class="map-overlay"></div>
                    <div class="after-product-summery"></div>
                    <div id="map" class="map-container"></div>

                </div><!-- .contact-map-container -->
            </div>

            <?php //________________ Tag Section ________________________?>
            <div class="w-100 job-sec-title-line"></div>
            <div class="w-100 d-flex pt-3 pb-3">
                @foreach(explode(',', $takhfif->tags )  as $tag)
                 @if(trim($tag))   <div class="single-tag-item">{{$tag}}</div>@endif
                @endforeach
            </div>

                <?php //________________ Comment Form Section ________________________?>
                <div class="comment-form-container w-100 mt-4 mb-4 p-4 position-relative">
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-1 usr-icon text-right"><i class="fas fa-user"></i></div>
                            <div class="col-md-5"><input type="text" name="" placeholder="نام"></div>
                            <div class="col-md-6"><input type="email" name="" placeholder="ایمیل"></div>
                            <div class="col-12">
                                <input type="submit" class="theme-btn orange-btn float-right mt-5" value="ارسال">
                            </div>
                        </div>
                    </form>
                    <img class="footer-side footer-side-right" src="{{asset($path_user.'img/footer-side.svg').'?ver='.$ver}}" alt="">
                    <img class="footer-side footer-side-left" src="{{asset($path_user.'img/footer-side.svg').'?ver='.$ver}}" alt="">
                </div>

                <?php //________________ Comments Content Section ________________________?>
                <div class="w-100 pt-4 mb-5">
                    <div class="comment-item-container w-100">
                        <div class="w-100 d-flex">
                            <div class="align-self-center">
                                <img class="circle-usr-img" src="{{asset(\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}" alt="" width="40" heigh='40'>
                            </div>
                            <div class="comment-content-container p-4 m-2">
                                <div class="w-100 row">
                                    <div class="col-8">
                                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
                                    </div>
                                    <div class="col-4 comment-content-status">
                                        <div><span class="pr-3"><i class="fa-solid fa-clock"></i></span><span class="pr-3">تاریخ</span><span> 14 مرداد 99 </span></div>
                                        <div><a class="font-weight-bold text-dark" href="#">پاسخ دهید</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php //____________ Comment Reply  _______________?>
                        <div class="comment-reply-item ml-md-5">
                            <div class="w-100 d-flex">
                                <div class="align-self-center">
                                    <img class="circle-usr-img" src="{{asset(\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}" alt="" width="40" heigh='40'>
                                </div>
                                <div class="comment-content-container p-4 m-2">
                                    <div class="w-100 row">
                                        <div class="col-8">
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود
                                        </div>
                                        <div class="col-4 comment-content-status">
                                            <div><span class="pr-3"><i class="fa-solid fa-clock"></i></span><span class="pr-3">تاریخ</span><span> 14 مرداد 99 </span></div>
                                            <div><a class="font-weight-bold text-dark" href="#">پاسخ دهید</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- .comment-item-container -->

                </div>


            <?php //________________ Today Off Section ________________________?>
            <div class="pt-4"></div>
            <div class="w-100">
                <div class="row">
                    <div class="job-sec-title-text">تخفیف های امروز</div>
                    <div class="col job-sec-title-line"></div>
                </div>
            </div>

            <!-- ______________home-line-thumb __________________________-->
                <div class="col-12 margin-content-fit  mt-3 mb-5">
                    @include('front.layouts.single.takhfif-tumb',['s_takhfifs'=>$today_takhfifs])

            </div>


            <?php //________________ Similar Off Section ________________________?>
            <div class="w-100">
                <div class="row">
                    <div class="job-sec-title-text">تخفیف های مشابه</div>
                    <div class="col job-sec-title-line"></div>
                </div>
            </div>

            <!-- ______________home-line-thumb __________________________-->
            <div class="col-12 margin-content-fit mt-3 mb-5">
                    @include('front.layouts.single.takhfif-tumb',['s_takhfifs'=>$similar_takhfifs])
            </div>

            <?php //____________________ Bottom Slider _______________________ ?>
            <div class="w-100 pt-5 pb-5 pl-3 pr-3">
                <div class="center position-relative" dir="ltr">

                    @include('front.layouts.logo-bar')

                </div>
            </div>

        </section><!--content-container-->
        @include('front.layouts.mail')

    </article>
@endsection
@push('style')

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
    <link rel="stylesheet" href="{{asset('plugins/leaflet/leaflet.js')}}"/>
    <script>
        var mapCenter = [{{$takhfif->shop?$takhfif->shop->lat:'32.62236'}}, {{$takhfif->shop?$takhfif->shop->lang:'51.66767'}}];
        var map = L.map('map', {center: mapCenter, zoom: 9});
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 15,
            id: 'sajjad234/cklor31nd251p17t66f9a99i3',
            tileSize: 512,
            language: 'local',
            zoomOffset: -1,
            accessToken: 'pk.eyJ1Ijoic2FqamFkMjM0IiwiYSI6ImNrbG5xcXdlcDBsbnEyd3FyeDR6OXd5N3MifQ.0BRrAzfheujkz0xSsZv_Sg'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);
        var updateMarker = function (lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("موقعیت :  " + marker.getLatLng().toString())
                .openPopup();
            return false;
        };

        var updateMarkerByInputs = function () {
            return updateMarker($('#latInput').val(), $('#lngInput').val());
        }
        $('#latInput').on('input', updateMarkerByInputs);
        $('#lngInput').on('input', updateMarkerByInputs);
    </script>
    <script>
        $(document).ready(function () {
            $('#add-to-cart').on("click", function (e) {
                e.preventDefault();
                $('#add-to-cart').attr('disabled', 'true');

                let count = $('#count').val();
                if (count.trim()) {
                    $('#page-overlay').css('display', 'block');
                    $('.spinner').css('display', 'block');

                    let id = $(this).attr('data-id');

                    $.ajax({
                        type: 'get',
                        url: '{{ url('add-to-cart') }}',
                        data: {
                            'count': count,
                            'id': id
                        },
                        success: function (response) {
                            if (response.success) {
                                $('.shop-cart').empty();
                                $('.shop-cart').append(response.view);
                                var toast_message = ' با موفقیت اضافه شد .';
                                sendMessage('موفق',toast_message);

                            } else {
                                var toast_message = response.error;
                                sendMessage('خطا',toast_message);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            if (xhr.status == 404) {
                                var toast_message = 'مورد پیدا نشد .';
                                sendMessage('خطا',toast_message);
                            }
                        }
                    }).always(function () {
                        $('#page-overlay').css('display', 'none');
                        $('.spinner').css('display', 'none');
                    });
                } else
                    sendMessage('خطا',"لطفا تعداد مورد نظر را وارد کنید!");
            });
        });
    </script>

@endpush
@push('external_css')
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>

@endpush
