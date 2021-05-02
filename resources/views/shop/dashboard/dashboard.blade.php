@extends('shop.layouts.master')

@section('content')

    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">داشبورد</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-sm-12" >
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="vc_row wpb_row row">
        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-primary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-user"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #0088cc;">تخفیف ها</span>
                                    </h4>
                                    <h4>{{number_format($takhfifs_count)}}</h4>
                                    <a class="more" href="{{ route('shop.takhfifs.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-secondary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-book"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #e36159;">تعداد سفارشات</span></h4>
                                    <h4>{{number_format($orders_count)}}</h4>
                                    <a class="more" href="{{ route('shop.coupon.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-tertiary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-trophy"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #2baab1;">مجموع سفارشات</span></h4>
                                    <h4>{{number_format($orders_sum)}}</h4>
                                    <a class="more" href="{{ route('shop.coupon.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-quaternary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-cogs"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #383f48;">موجو دی کیف پول </span></h4>
                                    <h4>{{number_format($wallet)}}</h4>
                                    <a class="more" href="{{ route('shop.refund.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-quaternary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-cogs"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #383f48;">درخواستهای برداشتهای پول</span></h4>
                                    <h4>{{number_format($refunds_count)}}</h4>
                                    <a class="more" href="{{ route('shop.refund.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-quaternary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-cogs"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #383f48;">برداشتهای پول</span></h4>
                                    <h4>{{number_format($refunds_approved_count)}}</h4>
                                    <a class="more" href="{{ route('shop.refund.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vc_column_container col-md-3">
            <div class="wpb_wrapper vc_column-inner">
                <div class="porto-content-box featured-boxes wpb_content_element  featured-boxes-style-7">
                    <div class="featured-box featured-box-quaternary featured-box-effect-7">
                        <div class="box-content" style="height: 170px;"><i class="icon-featured fa fa-cogs"></i>
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper"><h4><span style="color: #383f48;">مجموع برداشت پول</span></h4>
                                    <h4>{{number_format($refunds_approved_sum)}}</h4>
                                    <a class="more" href="{{ route('shop.refund.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('internal_js')
    <script>
        @if (count($chart))
        window.onload = function () {
                {{--console.log({{$chart}})--}}
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: @json($chart['label']),
                    datasets: [{
                        label: 'فروش روزانه',
                        backgroundColor: 'rgb(4,73,18)',
                        borderColor: 'rgb(246,113,41)',
                        data:  @json($chart['y'])
                    }]
                },

                // Configuration options go here
                options: {}
            });

        }
        @endif
    </script>

@endpush
@push('external_js')
{{--    <script src="{{asset('js/jquery.canvasjs.min.js')}}"></script>--}}
    <script src="{{asset('js/chart.js')}}"></script>

@endpush
