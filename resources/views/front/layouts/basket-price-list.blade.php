<div class="w-100 card-section p-4">
    <div class="w-100 title text-center">خلاصه سفارش</div>
    <div class="row cart-checkout-content">
        <div class="col-6">ارزش واقعی</div>
        <div class="col-6"><span class="basket-totalPrice_no_dis">{{number_format($totalPrice_no_dis) }}</span><span> تومان</span></div>
        <div class="col-6  text-danger">میزان تخفیف</div>
        <div class="col-6  text-danger"><span class="basket-total_discount">{{number_format($total_discount)}}</span><span> تومان</span></div>
        <div class="col-12 job-sec-title-line"></div>
        <div class="col-6">مبلغ قابل پرداخت</div>
        <div class="col-6 text-success"><span class="basket-totalPrice">{{number_format($totalPrice)}}</span><span> تومان</span></div>
    </div>
    <div class="w-100 d-flex">
        <div class="btn btn-success cart-page-btn"><a href="{{route('checkout')}}">تایید و ادامه</a> </div>
    </div>

</div>
