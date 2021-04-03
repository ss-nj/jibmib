@php($cart_items = \Illuminate\Support\Facades\Session::get('cart'))

<div class="dropdown position-relative">
    <button class="cart-btn primary-cart position-relative" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        سبد خرید
        <span><i class="fas fa-shopping-cart"></i></span>
        <div class="cart-item-num text-center">
            {{($cart_items ?count($cart_items):0)+$cart_count}}

        </div>
    </button>
    <div class="dropdown-menu card-section cart-header-menu bg-white p-2 pt-5 "
         aria-labelledby="dropdownMenuButton">
        @if($cart_items)
            @foreach($cart_items as $basket_item)
                <div class="d-flex">
                    <a href="{{route('single',$basket_item['slug'])}}">
                        <img src="{{asset($basket_item['image'])}}" alt="">

                    </a>
                    <div>
                        <a href="{{route('single',$basket_item['slug'])}}">
                            <div class="cart-item-title ml-2">{{$basket_item['name']}}</div>
                        </a>
                        <div class="cart-item-price-menu ml-2">
                            <div><span>{{number_format($basket_item['discount_price'])}}</span><span> تومان</span>

                                <span> تعداد</span>
                                <span>{{$basket_item['count']}}</span></div>
                        </div>
                    </div>

                    <a class="remove-from-cart" style="    left: 0;
    position: absolute;" href="{{route('remove.from.cart')}}" data-id="{{$basket_item['id']}}">
                        <div class="text-danger align-self-center"><i class="fa-regular fa-xmark"></i></div>
                    </a>
                </div>
            @endforeach
        @endif
        @if(auth()->check())
            @foreach($baskets as $basket_item)
                <div class="d-flex">
                    <a href="{{route('single',$basket_item->takhfif->slug)}}">
                        <img
                            src="{{asset($basket_item->takhfif->images->count()?$basket_item->takhfif->images->first()->path:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                            alt="">
                    </a>
                    <div>
                        <a href="{{route('single',$basket_item->takhfif->slug)}}">
                            <div class="cart-item-title ml-2">{{$basket_item->takhfif->name}}</div>
                        </a>
                        <div class="cart-item-price-menu ml-2">
                            <div><span>{{number_format($basket_item->takhfif->discount_price)}}</span><span> تومان</span>
                                <span> تعداد</span> <span>{{$basket_item->count}}</span></div>

                        </div>
                    </div>
                    <a class="remove-from-cart" style="    left: 0;
    position: absolute;" href="{{route('remove.from.cart')}}" data-id="{{$basket_item->takhfif->id}}">
                        <div class="text-danger align-self-center"><i class="fa-regular fa-xmark"></i></div>
                    </a>
                </div>
            @endforeach
        @endif
        <div class=" job-sec-title-line w-100"></div>
        <div class="mt-4 cart-menu-total-price"><span>مبلغ قابل پرداخت</span><span
                class="text-success">
                            {{number_format(($cart_items ? array_sum(array_column($cart_items,'discount_price')):0)+$cart_sum)}}
            </span><span
                class="text-success">تومان</span></div>
        <div class="w-100 job-sec-title-line"></div>
        <div class="w-100 d-flex ">
            <div class="btn btn-success cart-page-btn"><a href="{{route('view.basket')}}">تایید و ادامه</a></div>
        </div>
    </div>
</div>
