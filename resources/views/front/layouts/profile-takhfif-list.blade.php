@foreach($orders as $order)
    <div class=" ticket-section card-section mt-5 p-2">
        <div class="cart-item">
            <div class="d-sm-flex">
                <div class="text-center"><img src="{{$order->takhfif->image_first}}" alt=""></div>
                <div class="off-item-title d-flex flex-column">
                    <div class="p-2">
                        شماره سفارش
                        {{$order->order_id}}
                        تاریخ ثیت
                           {{verta($order->created_at)->timezone('Asia/Tehran')->format('Y/m/d')}}
                       {{$order->takhfif->name}}
                    </div>
                    <div class="d-flex p-2 mt-auto">
                        <div>
                            <span>قیمت اصلی: </span>
                            <span>{{number_format($order->takhfif->price)}}</span>
                            <span>تومان</span>
                        </div>
                        <div class="pl-2 text-success">
                            <span>پرداخت شما : </span>
                            <span>{{number_format($order->takhfif->discount_price)}}</span>
                            <span>تومان</span>
                        </div>
                        <div class="pl-2 text-danger">
                            <span>مقدار سود شما : </span>
                            <span>{{number_format($order->takhfif->price-$order->takhfif->discount_price)}}</span>
                            <span>تومان</span>
                        </div>
                    </div>
                </div>
                <a href="{{route('print',$order->code)}}" > <div class="align-self-center theme-btn green-btn ml-auto"><span><i
                            class="fa-regular fa-print"></i> </span>چاپ بلیط
                </div></a>
            </div>
            <hr>
            <div class="d-sm-flex justify-content-around">
                <div class="text-center">
                    <div class="font-weight-bold">کد QR</div>
                    <div><img class="thumb-qr-code" src="{{'img/users/'.auth()->id().'/coupons/'.$order->code.'.svg'}}" alt=""></div>
                </div>

                <div class="text-center d-flex flex-column  justify-content-between">
                    <div class="font-weight-bold">مدت اعتبار</div>
                    <div><span class="text-danger"> {{verta($order->takhfif->usage_start_time)->timezone('Asia/Tehran')->format('Y/m/d')}}</span><span> تا
                        </span><span class="text-danger">{{verta($order->takhfif->usage_expire_time)->timezone('Asia/Tehran')->format('Y/m/d')}}</span>
                    </div>
                </div>

                <div class="text-center d-flex flex-column  justify-content-between">
                    <div class="font-weight-bold">کد تخفیف</div>
                    <div>{{$order->code}}</div>
                </div>

                <div class="text-center d-flex flex-column  justify-content-between">
                    <div class="font-weight-bold">وضعیت تخفیف</div>
                    <div class="text-success">{{$order->status_text}}</div>
                </div>
            </div>
        </div><!-- .cart-item -->
    </div><!-- .ticket-section -->
@endforeach
