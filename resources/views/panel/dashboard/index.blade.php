@extends('panel.layouts.master')
@section('title')
    داشبورد
@endsection
@section('content')

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $todayUsersCount }}">0</span>
                    </div>
                    <div class="desc">ثبت نام امروز</div>
                </div>
                <a class="more" href="{{ route('users.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue">
                <div class="visual">
                    <i class="fa fa-cart-arrow-down"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $todayTransactions }}">0</span>
                    </div>
                    <div class="desc">تراکنش های امروز</div>
                </div>
                <a class="more" href="{{ route('transaction.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
        {{--        <div class="col-md-3 col-sm-6 col-xs-12">--}}
        {{--            <div class="dashboard-stat purple">--}}
        {{--                <div class="visual">--}}
        {{--                    <i class="fa fa-dollar"></i>--}}
        {{--                </div>--}}
        {{--                <div class="details">--}}
        {{--                    <div class="number">--}}
        {{--                        <span data-counter="counterup" data-value="{{ number_format($todaySells) }}">0</span>--}}
        {{--                    </div>--}}
        {{--                    <div class="desc">درآمد امروز</div>--}}
        {{--                </div>--}}
        {{--                <a class="more" href="{{ route('panel.reports.index') }}"> جزئیات بیشتر<i class="fa fa-arrow-left"></i></a>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold">آمار ماه گذشته</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="income-chart"></div>
                        </div>
                        <div class="col-lg-6">
                            <div id="transactions-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
            </div>
            <h4 class="page-title">آمار اعضا</h4>
            <p class="text-muted page-title-alt"></p>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank">

                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-plus mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        تعداد افراد عضو شده :
                        <span class="m-0 font-600 h3">{{number_format($usersCount)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-off mdi-36px "></i>
                    </div>
                    <div class="text-dark">
                        تعداد افراد غیر فعال توسط مدیر :
                        <span class="m-0 font-600 h3">{{number_format($notActiveUsersCount)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-check mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        تعداد افراد با شماره تایید شده :
                        <span class="m-0 font-600 h3">{{number_format($verifiedUsersCount)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-remove mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        تعداد افراد با شماره تایید نشده :
                        <span class="m-0 font-600 h3">{{number_format($notVerifiedUsersCount)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-multiple mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        تعداد اعضا فعال :
                        <span class="m-0 font-600 h3">{{number_format($activeVerifiedUsersCount)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('panel.tickets.index')}}">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-multiple mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        تیکتهای پاسخ داده نشده :
                        <span class="m-0 font-600 h3">{{number_format($activeNotAnswerdTicketCount)}}</span>
                    </div>
                </div>
            </a>
        </div>

    </div>

 <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
            </div>
            <h4 class="page-title">آمار فروش</h4>
            <p class="text-muted page-title-alt"></p>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('transaction.index')}}">

                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-plus mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        مجموع خرید های امروز :
                        <span class="m-0 font-600 h3">{{number_format($todaySells)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('transaction.index')}}">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-off mdi-36px "></i>
                    </div>
                    <div class="text-dark">
                        خرید های امروز :
                        <span class="m-0 font-600 h3">{{number_format($todayTransactions)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('transaction.index')}}">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-check mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        خرید های هفته :
                        <span class="m-0 font-600 h3">{{number_format($weekSells)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('transaction.index')}}">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-remove mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        مجموع خرید های هفته :
                        <span class="m-0 font-600 h3">{{number_format($weekTransactions)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('transaction.index')}}">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-multiple mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        خرید های ماه :
                        <span class="m-0 font-600 h3">{{number_format($monthSells)}}</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3 kt-margin-t-15 ">
            <a target="_blank" href="{{route('transaction.index')}}">
                <div class="widget-panel dashboard-boxes">
                    <div class="font-bold m-t-5 text-b-Jibmib">
                        <i class="mdi mdi-account-multiple mdi-36px"></i>
                    </div>
                    <div class="text-dark">
                        مجموع خرید های ماه :
                        <span class="m-0 font-600 h3">{{number_format($monthTransactions)}}</span>
                    </div>
                </div>
            </a>
        </div>

    </div>


@endsection

@push('internal_js')
    <script>
        $(function () {
            Highcharts.setOptions({});
            Highcharts.chart('income-chart', {
                chart: {
                    type: 'spline',
                    style: {
                        fontFamily: 'IRANSans'
                    }
                },
                xAxis: {
                    categories: {!! json_encode($income['days']) !!},
                    labels: {
                        useHTML: true
                    }
                },
                yAxis: {
                    title: {
                        text: '',
                        useHTML: true
                    },
                    labels: {
                        useHTML: true
                    }
                },
                title: {
                    text: 'ورودی ها',
                    useHTML: true
                },
                legend: {
                    useHTML: true
                },
                tooltip: {
                    headerFormat: '<div class="text-right">',
                    footerFormat: '</div>',
                    pointFormat: '{series.name} : <b>{point.y:,.0f}</b> عدد',
                    useHTML: true
                },
                credits: {
                    enabled: false
                },
                series: [
                    {
                        name: 'کاربر',
                        data: {!! json_encode($income['users']) !!}
                    },
                    {
                        name: 'فروشگاه',
                        data: {!! json_encode($income['shops']) !!}
                    }
                ]
            });
            Highcharts.setOptions({
                colors: [
                    '#f35f59',
                    '#56e05d'
                ]
            });
            Highcharts.chart('transactions-chart', {
                chart: {
                    type: 'spline',
                    style: {
                        fontFamily: 'IRANSans'
                    }
                },
                xAxis: {
                    categories: {!! json_encode($transactions['days']) !!},
                    labels: {
                        useHTML: true
                    }
                },
                yAxis: {
                    title: {
                        text: '',
                        useHTML: true
                    },
                    labels: {
                        useHTML: true
                    }
                },
                title: {
                    text: 'تراکنش ها',
                    useHTML: true
                },
                legend: {
                    useHTML: true
                },
                tooltip: {
                    headerFormat: '<div class="text-right">',
                    footerFormat: '</div>',
                    pointFormat: '{series.name} : <b>{point.y:,.0f}</b> عدد',
                    useHTML: true
                },
                credits: {
                    enabled: false
                },
                series: [
                    {
                        name: 'ناموفق',
                        data: {!! json_encode($transactions['failed']) !!}
                    },
                    {
                        name: 'موفق',
                        data: {!! json_encode($transactions['success']) !!}
                    }
                ]
            });
        });
    </script>
@endpush

@push('external_js')
    <script src="{{ asset('plugins/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('plugins/counterup/jquery.waypoints.min.js') }}"></script>
@endpush
