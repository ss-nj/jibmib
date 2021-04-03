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
                            <?php for($i=1; $i<=4; $i++): ?>
                            <div class="bank-item col-12 pt-5 ">
                                <div class="d-flex">
                                    <input class="align-self-center mr-3" id="bank-<?php echo $i ?>" type="radio" name="bank">
                                    <label class="w-100 d-flex" for="bank-<?php echo $i ?>">
                                        <img src="img/mellat-logo.png" alt="">
                                        <div class="align-self-center ml-3">پرداخت اینترنتی - بانک سامان</div>
                                        <div class="align-self-center ml-auto">قابل پرداخت با تمامی کارت های عضو شتاب</div>
                                    </label>
                                </div>
                            </div><!-- .cart-item -->
                            <?php endfor; ?>
                        </div>
                    </div><!-- .card-section -->

                    <!-- ________________________ OFF Code _____________________ -->
                    <div class="w-100 card-section p-4 mt-4">
                        <div class="title">کد تخفیف</div>
                        <div class="row">
                            <div class="col-sm-6 align-self-center">اگر کد تخفیف دارید در این بخش وارد کنید و دکمه ثبت را بزنید</div>
                            <div class="col-sm-6 align-self-center">
                                <input class="w-75 card-section mr-3 checkout-off-form" type="text" name="">
                                <div class="btn btn-success cart-page-btn">ثبت</div>
                            </div>
                        </div>
                    </div><!-- .card-section -->

                </div><!-- .col-md-9 -->


                <?php //_____________________ Checkout Detail ___________________ ?>
                <div class="col-md-3 mt-md-0 mt-3">
                    @include('front.layouts.basket-price-list')
                </div>

            </div>
        </section>

    </article>
@endsection

