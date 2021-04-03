@extends('panel.layouts.master')
@section('title')
    داشبورد
@endsection
@section('content')
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
                        <span class="m-0 font-600 h3">{{$usersCount}}</span>
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
                        <span class="m-0 font-600 h3">{{$notActiveUsersCount}}</span>
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
                        <span class="m-0 font-600 h3">{{$verifiedUsersCount}}</span>
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
                        <span class="m-0 font-600 h3">{{$notVerifiedUsersCount}}</span>
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
                        <span class="m-0 font-600 h3">{{$activeVerifiedUsersCount}}</span>
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
                        <span class="m-0 font-600 h3">{{$activeNotAnswerdTicketCount}}</span>
                    </div>
                </div>
            </a>
        </div>

    </div>


@endsection
