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

<script>
    $(document).on('submit', '.ajax_validate', function (e) {
        // console.log(1)
        e.preventDefault();//Prevent from submitting

        submiter($(this))
    })

    function success(response) {
        $('.error_field').text('');

        var result = response.data
        if (result.function) {
            // console.log(result.args.toString())
            // window[result.function](result.args.toString());
            window[result.function].apply(window, result.args.toString().split(','))

        }
        if (result.status) {
            if (result.action) {
                if (result.action === "REFRESH") {
                    location.reload();
                    return;
                }
                if (result.action === "DATATABLE_REFRESH") {
                    $('.close-modal').click();
                    $('.buttons-reset').click();
                    return;
                }
                if (result.action === "REDIRECT") {
                    url = result.url.substr(0, 4) === "http" ? result.url : url + result.url;
                    window.location.replace(url);
                    return;
                }
                if (result.action === "ACTION_ALERT") {
                    url = result.url.substr(0, 4) === "http" ? result.url : url + result.url;
                    if (result.mode === "swal") {
                        swal("", result.message, result.color);
                        $(".swal2-confirm").click(function () {
                            window.location.replace(url);
                        });
                        return;
                    } else if (result.mode === "toastr") {
                        toastr[result.color](result.message);
                        setTimeout(function () {
                            window.location.replace(url);
                        }, 800)
                        return;
                    }
                }
            }
            swal(result.title, result.message, "success");
        } else {
            swal(result.title, result.message, "error");
        }
    }

    function submiter(form) {
        //get form
        //remove the invalid class
        $(document).find(':input').removeClass("is-invalid");

        let formData = new FormData();
        //Append File

        form.find('input[type="file"]').each(function () {
            let val = $(this).prop("files")[0],
                field = $(this).attr('name');
            formData.append(field, val);
        });

        //Append Other Data
        $.each(form.serializeArray(), function (key, input) {
            formData.append(input.name, input.value);
        });
        console.log(formData)
        axios.post(form.attr('action'),
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then(function (response) {
            //Success

            //must get( message , title , action   , link)
            success(response)

        }).catch(function (errors) {
            swal('خطا', 'لطفا تمام فیلدهای اجباری را به طور صحیح تکمیل کنید', "error");

            $('.error_field').text('');
            if(error.response.status===404)
            {
                sendMessage('خطا','موزد پیدا نشد');
            }
            $.each(errors.response.data.errors, function (key, val) {
                validate(key, val, form)

            });
        });
    }

    function validate(key, val, form) {
        let input = form.find("." + key);
        console.log(input)

        input.addClass('is-invalid');
        input.next(".error_field").text(val[0]);

        // setTimeout(function () {
        //     input.removeClass("is-invalid");
        // }, 10000)
    }

    function sendMessage(title, message) {
        swal(message, {
            dangerMode: false,
            icon: title === 'خطا' ? "error" : "success",
            title: title,
            showCloseButton: false,

            buttons: {
                confirm: "تایید",
            },
        });
    }

    function toast(title, message, color = 'rgb(0, 255, 184)') {
        // color = color || 'rgb(0, 255, 184)';
        iziToast.show({
            id: 'haduken',
            theme: 'dark',
            icon: 'icon-contacts',
            title: title,
            displayMode: 0,
            message: message,
            position: 'topCenter',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX',
            progressBarColor: color,
            // image: image,
            imageWidth: 70,
            layout: 2,
            onClosing: function () {
                // console.info('onClosing');
            },
            onClosed: function (instance, toast, closedBy, on_closed) {
                if (on_closed) {
                    $('.close-modal').click();
                    location.reload();
                }
            },
            iconColor: 'rgb(0, 255, 184)'
        });
    }


</script>
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
