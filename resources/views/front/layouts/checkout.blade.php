@foreach($baskets as $basket)
    <div class="col-lg-4 col-md-6 col-12">
        <div class="checkout-item mt-3">
            <div class="w-100 pt-2 pl-2">
                <div class="d-flex">
                    <img
                        src="{{asset($basket->takhfif->images->count()>0?$basket->takhfif->images->first()->path:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                        alt="">
                    <div class="cart-item-title">
                        <a href="{{route('single',$basket->takhfif->slug)}}">
                            <p> {{\Illuminate\Support\Str::limit($basket->takhfif->name,200)}}</p>
                        </a>

                        <div><span>{{$basket->count}}</span><span>عدد</span></div>
                    </div>

                </div>
                <div class="flex-row-reverse checkout-item-price w-100 p-3 mt-2 d-flex">
                    <div class="cart-off-value text-center">{{$basket->takhfif->discount}}%</div>
                    <div class="text-success"><span>{{number_format($basket->takhfif->discount_price)}}</span><span>تومان</span></div>

                </div>

            </div><!-- .w-100 -->
        </div><!-- .checkout-item -->
    </div>
@endforeach
