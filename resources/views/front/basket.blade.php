@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="content-container cart-container mb-5">
            <div class="row w-100 pt-5">
                <?php //________________________ Cart Items _____________________ ?>
                <div class="col-md-9">
                    <div class="w-100 card-section p-4" id="user-basket">
                        @include('front.layouts.basket')
                    </div>
                </div>
                <?php //_____________________ Checkout Detail ___________________ ?>
                <div class="col-md-3">
                    @include('front.layouts.basket-price-list')

                </div>

            </div>
        </section>

    </article>
@endsection

