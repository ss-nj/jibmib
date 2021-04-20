@extends('shop.layouts.master')

@section('title')مدیریت کوپنها@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">لیست کوپنها</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.coupon.index')}}">لیست کوپنهای فروش رفته</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
        <h4 class="mb-4"> </h4>

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام مشتری</th>
                            <th>تاریخ خرید</th>
                            <th>نام تخفیف</th>
                            <th>تعداد</th>
                            <th>قیمت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{$coupon->id}}</td>

                                <td>{{$coupon->user->full_name}}</td>
                                <td>
                                    {{verta($coupon->created_at)->timezone('Asia/Tehran')->format('Y-m-d')}}
                                </td>
                                <td>{{$coupon->takhfif->name}}</td>

                                <td>{{$coupon->takhfif_count}}</td>
                                <td>{{$coupon->takhfif->discount_price}}</td>
                                <td class="text-success">{{$coupon->status_text}}</td>
                                <td></td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



@endsection


