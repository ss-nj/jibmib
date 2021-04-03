<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{trim($siteSettings['site_name']->value_fa)}}| @yield('title')</title>
    <link rel="stylesheet" href="{{asset($path_user.'css/all.min.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/bootstrap.rtl.min.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/fontiran.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/slick.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/slick-theme.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/style.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'style.css').'?ver='.$ver}}" type='text/css' media='all'/>
</head>
<body class="gray-bg">

<article class="w-100 position-relative gray-bg login-page-container">
    <img class="login-bg-top" src="{{asset($path_user.'img/login-bg-top.svg').'?ver='.$ver}}" alt="">
    <img class="login-logo-top" src="{{asset($path_user.'img/logo.png').'?ver='.$ver}}" alt="">
    <img class="login-bg-bottom" src="{{asset($path_user.'img/login-bg-bottom.svg').'?ver='.$ver}}" alt="">
    <section class="login-container">
        <div class="row w-100">
            <div class="col-md-4">
                <div class="login-title"><h1 class="text-white">ورود به سایت</h1></div>
            </div>
            <div class="col-md-8">
                <div class="login-form-container">
                    <form action="#" method="post" class="pt-5">
                        <div class="row">
                            <div class="col-12">
                                <input type="tel" class=" form-control" name="mobile" value=""
                                       maxlength="11" minlength="10"
                                       pattern="^09[0-9]{9}$"
                                       title="شماره موبایل را به صورت صحیح وارد کنید."
                                       placeholder="شماره موبایل خود را وارد نمایید"

                                       oninput="
                           this.value = this.value.replace('۰', '0')  ;
                           this.value = this.value.replace('۱', '1')  ;
                           this.value = this.value.replace('۲', '2')  ;
                           this.value = this.value.replace('۳', '3')  ;
                           this.value = this.value.replace('۴', '4')  ;
                           this.value = this.value.replace('۵', '5')  ;
                           this.value = this.value.replace('۶', '6')  ;
                           this.value = this.value.replace('۷', '7')  ;
                           this.value = this.value.replace('۸', '8')  ;
                           this.value = this.value.replace('۹', '9')  ;
                           this.value = this.value.replace('٤', '4')  ;
                           this.value = this.value.replace('٥', '5')  ;
                           this.value = this.value.replace('٦', '6')  ;
                           this.value = this.value.replace(/[^0-9۰-۹.]/g, '');
                           this.value = this.value.replace(/(\..*)\./g, '$1');"

                                >
                                <div class="error_field text-danger"></div>
                            <div class="col-12">
                                <input type="password" name="" placeholder="گذرواژه خود را وارد نمائید">
                                <div class="error_field text-danger"></div>

                            </div>
                            <div class="col-sm-6 pt-4">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="remember">
                                    <span class="checkmark"></span>
                                    مرا بخاطر بسپار
                                </label>
                                <div class="error_field text-danger"></div>

                            </div>
                            <div class="col-sm-6 text-center pt-4">
                                <p>گذرواژه خود را فراموش کرده ام</p>
                                <p><span class="text-danger"><a href="{{url('user-confirm')}}">گذرواژه خود را فراموش کرده ام</a></span></p>

                            </div>
                            <div class="login-new-user col-sm-7 pt-5 text-center mt-5">
                                <p><span>کاربر جدید هستید؟</span><span class="text-danger"><a href="{{route('register.form')}}"> ثبت نام کنید</a></span></p>
                            </div>
                            <div class="col-sm-5 pt-5">
                                <input class="btn btn-warning" type="submit" name="" value="ورود به سایت">
                            </div>

                        </div>
                    </form>
                </div><!--login-form-container-->
            </div><!--col-md-6-->
        </div><!--row-->
    </section>

</article><!--login-container-->

<script src="{{ asset('jquery.min.js').'?ver='.$ver}}"></script>

<script src="{{ asset('js/bootstrap.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset('js/jquery-migrate.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset('js/slick.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset('js/theme-scripts.js').'?ver='.$ver}}"></script>


</body>
</html>

