@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="content-container cart-container mb-5">
            <div class="row w-100 pt-5">

                <div class="col-md-9">
                    <!-- ________________________ Checkout Items _____________________ -->
                    <div class="w-100 card-section p-sm-4">
                        <div class="title">سفارش ها</div>
                        <div class="row">
                               @include('front.layouts.checkout')

                        </div>
                    </div><!-- .card-section -->

                    <!-- ________________________ Bank Items _____________________ -->
                    <div class="w-100 card-section p-sm-4 mt-4">
                        <div class="title">انتخاب نحوه پرداخت</div>
                        <div class="row">
                            <?php for($i=1; $i<=1; $i++): ?>
                            <div class="bank-item col-12 pt-5 ">
                                <div class="d-flex">
                                    <input class="align-self-center mr-3" id="bank-<?php echo $i ?>" type="radio" name="bank">
                                    <label class="w-100 d-flex" for="bank-<?php echo $i ?>">
                                        <img src="{{asset($path_user.'img/mellat-logo.png')}}" alt="">
                                        <div class="align-self-center ml-3">پرداخت اینترنتی - بانک ملت</div>
                                        <div class="align-self-center ml-auto">قابل پرداخت با تمامی کارت های عضو شتاب</div>
                                    </label>
                                </div>
                            </div><!-- .cart-item -->
                            <?php endfor; ?>
                        </div>
                    </div><!-- .card-section -->

                    <!-- ________________________ OFF Code _____________________ -->
{{--                    <div class="w-100 card-section p-4 mt-4">--}}
{{--                        <div class="title">کد تخفیف</div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-sm-6 align-self-center">اگر کد تخفیف دارید در این بخش وارد کنید و دکمه ثبت را بزنید</div>--}}
{{--                            <div class="col-sm-6 align-self-center">--}}
{{--                                <input class="w-75 card-section mr-3 checkout-off-form" type="text" name="">--}}
{{--                                <div class="btn btn-success cart-page-btn">ثبت</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- .card-section -->--}}

                </div><!-- .col-md-9 -->


                <?php //_____________________ Checkout Detail ___________________ ?>
                <div class="col-md-3 mt-md-0 mt-3">
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
                            <div class="btn btn-success cart-page-btn"><a href="{{route('basket.pay')}}">تایید و ادامه</a> </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>

    </article>
@endsection

