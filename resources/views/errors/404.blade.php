@extends('front.layouts.master')

@section('content')
    <article class="w-100 position-relative">
        <section class="content-container cart-container mb-5">
            <div class=" w-100 pt-5">

                <div class="card-section mt-5 confirm-payment-section d-flex flex-column">

                    <div class="align-self-center p-2 m-auto">
                        <div class="text-center" style="font-size: 3rem;"><i class="fa-solid fa-exclamation"></i>404
                        </div>
                        <p class="text-center">صفحه مورد نظر یافت نشد </p>
                        @include('front.layouts.mail')
                    </div>


                </div><!-- .confirm-payment-section -->

            </div>
        </section>
    </article>
@endsection
