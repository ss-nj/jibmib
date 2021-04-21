@extends('shop.layouts.master')

@section('title')مدیریت تراکنشها@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">لیست تراکنشها</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.coupon.index')}}">لیست تراکنشها</a></li>
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
                            <th>لیست خرید</th>
                            <th>تعداد</th>
                            <th>قیمت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->id}}</td>

                                <td>{{$transaction->user->full_name}}</td>
                                <td>
                                    {{verta($transaction->created_at)->timezone('Asia/Tehran')->format('Y-m-d H:i')}}
                                </td>
                                <td></td>

                                <td>{{$transaction->orders_count}}</td>
                                <td>{{number_format($transaction->amount)}}</td>
                                <td >{{$transaction->status_text}}</td>
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


