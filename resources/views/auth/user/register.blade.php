<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{trim($siteSettings['site_name']->value_fa)}}| @yield('title')</title>
    <link rel="stylesheet" href="{{asset($path_user.'css/all.min.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/bootstrap.rtl.min.css').'?ver='.$ver}}" type='text/css'
          media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/fontiran.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/slick.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/slick-theme.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'css/style.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <link rel="stylesheet" href="{{asset($path_user.'style.css').'?ver='.$ver}}" type='text/css' media='all'/>
    <script src="{{ asset($path_user.'js/jquery.min.js').'?ver='.$ver}}"></script>
    <link href="{{asset('plugins/iziToast/dist/css/iziToast.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        .swal-text {
            text-align: center;
        }
    </style>
</head>
<body class="gray-bg">

<article class="w-100 position-relative gray-bg login-page-container">
    <img class="login-bg-top" src="{{asset($path_user.'img/login-bg-top.svg').'?ver='.$ver}}" alt="">
    <img class="login-logo-top" src="{{asset(trim($siteSettings['site_logo']->value_fa)).'?ver='.$ver}}" alt="">
    <img class="login-bg-bottom" src="{{asset($path_user.'img/login-bg-bottom.svg').'?ver='.$ver}}" alt="">
    <section class="login-container">
        <div class="row w-100">
            <div class="col-md-4">
                <div class="login-title"><h1 class="text-white">ثبت نام سایت</h1></div>
            </div>
            <div class="col-md-8">
                <div class="login-form-container register-form-container">
                    <form method="POST" action="{{ route('user.register') }}" class="ajax_validate" id="register-form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="first_name" name="first_name"
                                       placeholder="نام و نام خانوادگی">
                                <div class="error_field text-danger"></div>
                            </div>
                            <div class="col-12">
                                <input type="text" class="mobile" name="mobile" value="" id="mobile"
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
                            </div>
                            <div class="col-12">
                                <input type="password" name="password" class="password"
                                       placeholder="گذرواژه خود را وارد نمائید">
                                <div class="error_field text-danger"></div>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="code verify-field" name="code"
                                       placeholder="کد ارسال شده به تلفن همراه خود را وارد کنید">
                                <div class="error_field text-danger"></div>
                            </div>
                            <div class="col-sm-4 text-center pt-2">
                                <input type="hidden" value="1" id="verify-field" name="request_verify" disabled>
                                <button style="width: 100%" type="button" id="verify-field-bot" class="btn btn-success ">
                                    <i class="">درخواست کد تایید</i></button>
                            </div>


                            <div class="col-sm-12">
                                <label class="checkbox-container  login-new-user">
                                    <input type="hidden" name="policy" value="0">
                                    <input type="checkbox" name="policy" class="policy" value="1">
                                    <span class="checkmark"></span>
                                    <span class="text-danger"><a
                                            href="{{route('policy')}}"> حریم خصوصی و شرایط و قوانین</a></span>
                                    <span> استفاده از سرویس های سایت  را مطالعه نمودم و با کلیه موارد آن موافقم</span>
                                </label>
                                <div class="error_field text-danger"></div>

                            </div>
                            <div class="login-new-user col-sm-7 text-center">
                                <p><span>قبلا در سایت ثبت نام کردید ؟ </span>
                                    <span class="text-danger"><a href="{{route('login.form')}}"> وارد شوید</a></span>
                                </p>
                            </div>
                            <div class="col-sm-5">
                                <input class="btn btn-warning" id="register-bot" type="submit" name=""
                                       value="ثبت نام سایت">
                            </div>

                        </div>
                    </form>
                </div><!--login-form-container-->
            </div><!--col-md-6-->
        </div><!--row-->
    </section>

</article><!--login-container-->


<script src="{{ asset($path_user.'js/bootstrap.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset($path_user.'js/jquery-migrate.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset($path_user.'js/slick.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset($path_user.'js/theme-scripts.js').'?ver='.$ver}}"></script>
<script src="{{asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/iziToast/dist/js/iziToast.min.js') }}"></script>

@include('layouts.submitter-js')
<script>
    function verifySent() {

        let verifyBot = $('#verify-field-bot');

        verifyBot.prop('disabled', true);
        verifyBot.text('تلاش دوباره');

        setTimeout(function () {
            verifyBot.prop('disabled', false);
            verifyBot.text('درخواست کد تایید');
        }, 12000)

    }

    $(document).on('click', '#verify-field-bot', function () {
        $('#verify-field').prop('disabled', false);
        $('#register-form').submit();
        $('#verify-field').prop('disabled', true);

    })
</script>

</body>
</html>
