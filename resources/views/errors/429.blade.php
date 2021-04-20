@extends('layouts.master')

@section('title')
    خطای 404
@endsection

@section('content')
    <style>
        .notfound .notfound-bg>div:nth-child(1) {
            -webkit-box-shadow: 5px 5px 0 0 #f3f3f3;
            box-shadow: 5px 5px 0 0 #f3f3f3;
        }

        .notfound .notfound-bg>div {
            width: 100%;
            background: #fff;
            border-radius: 90px;
            height: 125px;
        }
        .notfound .notfound-bg {
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: -1;
        }
        .notfound .notfound-bg>div:nth-child(2) {
            -webkit-transform: scale(1.3);
            -ms-transform: scale(1.3);
            transform: scale(1.3);
            -webkit-box-shadow: 5px 5px 0 0 #f3f3f3;
            box-shadow: 5px 5px 0 0 #f3f3f3;
            position: relative;
            z-index: 10;
        }
        .notfound .notfound-bg>div {
            width: 100%;
            background: #fff;
            border-radius: 90px;
            height: 125px;
        }
        .notfound .notfound-bg>div:nth-child(3) {
            -webkit-box-shadow: 5px 5px 0 0 #f3f3f3;
            box-shadow: 5px 5px 0 0 #f3f3f3;
            position: relative;
            z-index: 90;
        }

        .notfound .notfound-bg>div {
            width: 100%;
            background: #fff;
            border-radius: 90px;
            height: 125px;
        }
        #notfound {
            position: relative;
            height: 100vh;
            background-color: #fafbfd;
        }
        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%,-50%);
            -ms-transform: translate(-50%,-50%);
            transform: translate(-50%,-50%);
        }
        .notfound {
            max-width: 520px;
            width: 100%;
            text-align: center;
        }
    </style>
    <main class="main-content dt-sl mt-4 mb-3">
        <div id="page-overlay"></div>
        <div class="spinner"></div>
        <div class="container main-container">
            <!-- Start title - breadcrumb -->

                <div class="" dir="rtl">
                    <div class="category-products">
                        <div id="notfound">
                            <div class="notfound">
                                <div class="notfound-bg">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <h1> با عرض پوزش </h1>
                                <h2>تنها سه بار در هر دقیقه مجاز به تلاش هستید </h2>
                                <p>کمی صبر کنید و دوباره تلاش کنید</p>
                                <a href="{{url('/')}}">بازگشت dfdfبه صفحه اصلی</a>
                                <div class="notfound-social">
                                    {{--                            <a href="#"><i class="fa fa-facebook"></i></a>--}}
                                    {{--                            <a href="#"><i class="fa fa-twitter"></i></a>--}}
                                    {{--                            <a href="#"><i class="fa fa-pinterest"></i></a>--}}
                                    {{--                            <a href="#"><i class="fa fa-google-plus"></i></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


        </div>
    </main>

@endsection
