@extends('front.layouts.master')


@section('content')
    <article class="w-100 position-relative">
        <section class="content-container cart-container mb-5">
            <div class=" w-100 pt-5">

                @if(isset($message))
                    <div class="card-section mt-5 confirm-payment-section d-flex flex-column">
                        <h1>موفق</h1>
                        <div class="align-self-center p-2 m-auto">
                            {{$message}}
                            <div class="btn btn-success cart-page-btn mr-auto"><a href="{{route('home')}}">بازکشت به صفحه اصلی</a></div>
                        </div>
                    </div><!-- .confirm-payment-section -->
                @endif
            </div>
            <div class=" w-100 pt-5">

                @if(isset($transaction))
                    <div class="card-section mt-5 confirm-payment-section d-flex flex-column">
                        <h1>موفق</h1>
                        <div class="align-self-center p-2 m-auto">
                            پرداخت شما با موفقیت انجام شد. شماره رهگیری سفارش شما
                            <span>{{$transaction->track_code}}</span>
                            <a href="{{route('profile.index').'#home'}}"> <div class="btn btn-success cart-page-btn mr-auto">مشاهده بلیط ها</div></a>
                        </div>
                    </div><!-- .confirm-payment-section -->
                @endif
            </div>
        </section>
    </article>
@endsection
