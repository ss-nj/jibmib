@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="small-content-container cart-container mb-5">

            <!-- _______________________ Profile Title Section ___________________ -->

            <div class=" ticket-section card-section mt-5 p-2">
                <div class="d-sm-flex  justify-content-between">
                    <div>
                        <div class="p-1">
                            <span class="font-weight-bold">شماره سفارش: </span>
                            <span>{{$order->order_id}}</span>
                        </div>
                        <div class="p-1">
                            <span class="font-weight-bold">بلیط : </span>
                            <span>{{$order->takhfif->name}}</span>
                        </div>
                        <div class="p-1">
                            <span class="font-weight-bold">تعداد بلیط : </span>
                            <span>{{$order->takhfif_count}}</span><span> عدد</span>
                        </div>
                    </div>
                    <div class="text-center align-self-center">
                        <div class="font-weight-bold">مدت اعتبار</div>
                        <div><span
                                class="text-danger"> {{verta($order->takhfif->usage_start_time)->timezone('Asia/Tehran')->format('Y/m/d')}}</span><span> تا
                        </span><span
                                class="text-danger">{{verta($order->takhfif->usage_expire_time)->timezone('Asia/Tehran')->format('Y/m/d')}}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <div><img src="{{asset('img/users/'.auth()->id().'/coupons/'.$order->code.'.svg')}}" alt="">
                        </div>
                        <div class="pt-2"><span class="font-weight-bold">کد تخفیف</span><span>{{$order->code}}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between p-4">
                    <div>
                        <div class="font-weight-bold">آدرس:</div>
                        <div>{{$order->takhfif->shop->full_address}}</div>
                    </div>
                    @if($order->takhfif->shop->lat &&$order->takhfif->shop->lang)
                        <div class="text-center">
                            {!!  \SimpleSoftwareIO\QrCode\Facades\QrCode::generate(sprintf('http://www.google.com/maps/place/%s,%s/@%s,%s,10z'
                                             ,$order->takhfif->shop->lat,$order->takhfif->shop->lang
                                             ,$order->takhfif->shop->lat,$order->takhfif->shop->lang))!!}

                            <div class="pt-2">نشانی را از روی نقشه بیابید</div>
                        </div>
                    @endif
                </div>

            </div><!-- .ticket-section -->
            <div class="d-flex justify-content-end print-ticket">
                <div class="theme-btn green-btn mt-4" onclick="window.print()"><span><i class="fa-regular fa-print"></i> </span>چاپ
                    بلیط
                </div>
            </div>


        </section>
    </article>
@endsection
