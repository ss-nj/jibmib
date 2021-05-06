<div class="title">سبد خرید</div>
@foreach($baskets as $basket)
    <div class="cart-item pt-5 " id="basket-item-no-{{$basket->takhfif->id}}">
        <div class="row">
            <div class="col-sm-6">
                <div class="d-flex">
                    <a href="{{route('single',$basket->takhfif->slug)}}">
                        <img
                            src="{{asset($basket->takhfif->images->count()>0?$basket->takhfif->images->first()->path:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                            alt="">
                    </a>
                    <a href="{{route('single',$basket->takhfif->slug)}}">
                        <div class="cart-item-title">{{$basket->takhfif->name}}</div>
                    </a>
                    <div class="cart-off-value text-center">{{$basket->takhfif->discount}}%</div>

                </div>
            </div><!-- .col-sm-6 -->
            <div class="col-sm-6">
                <div class="d-flex ml-sm-4 mt-4">
                    <div class="cart-item-counter d-flex">
                        <div><i class="fa-regular fa-plus takhfif-count-plus" data-id="{{$basket->id}}"></i></div>
                        <div id="takhfif-count-{{$basket->id}}">{{$basket->count}}</div>
                        <div><i class="fa-regular fa-minus takhfif-count-minus" data-id="{{$basket->id}}"></i></div>
                    </div>
                    <div class="cart-item-price ml-5">
                        <div><span>{{number_format($basket->takhfif->discount_price*$basket->count)}}</span><span> تومان</span></div>
                        <div>{{$basket->takhfif->price*$basket->count}}</div>
                        <div></div>
                    </div>
                    <a class="remove-from-cart" href="{{route('remove.from.cart')}}" data-id="{{$basket->takhfif->id}}">
                        <div class="cart-item-trash ml-sm-5"><i class="fa-light fa-trash-can"></i>
                        </div>
                    </a>
                </div>
            </div><!-- .col-sm-6 -->
        </div>
    </div><!-- .cart-item -->
    <hr>
@endforeach

@push('internal_js')
    <script>
        function changeCount(count,id) {
            $.ajax({
                type: 'get',
                url: '{{ route('change.count.ajax') }}',
                data: {
                    'id': id,
                    'count': count,
                },
                success: function (response) {
                    if (response.success) {
                        refreshcart()

                    } else {
                        let toast_message = response.error;
                        sendMessage('خطا', toast_message);
                    }
                },
                error: function (response) {
                    if (response.status == 404) {
                        var toast_message = 'مورد پیدا نشد .';
                        sendMessage('خطا', toast_message);
                    }
                    console.log(response.responseJSON.errors.count[0] )
                    sendMessage('خطا', response.responseJSON.errors.count[0]);
                }
            }).always(function () {
                $('#page-overlay').css('display', 'none');
                $('.spinner').css('display', 'none');
            });
        }

        $(document).on('click', '.takhfif-count-plus', function (e) {
            e.preventDefault();
            $('#page-overlay').css('display', 'block');
            $('.spinner').css('display', 'block');

            let id = $(this).attr('data-id');
            let takhfifCountField = $('#takhfif-count-' + id);
            let count = parseInt(takhfifCountField.text())+1;
            changeCount(count,id);

        })

         $(document).on('click', '.takhfif-count-minus', function (e) {
            e.preventDefault();

             // $('#page-overlay').css('display', 'block');
             // $('.spinner').css('display', 'block');
            let id = $(this).attr('data-id');
            let takhfifCountField = $('#takhfif-count-' + id);
            let count = parseInt(takhfifCountField.text())-1;
            if (count<1) {
                $('#page-overlay').css('display', 'none');
                $('.spinner').css('display', 'none');
                return
            }



             changeCount(count,id);

        })


    </script>
@endpush

