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
                <div class="login-title"><h1 class="text-white">ورود به سایت</h1></div>
            </div>
            <div class="col-md-8">
                <div class="login-form-container">
                    <form action="{{ route('user.login') }}" method="post" class="pt-5 ajax_validate">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <input type="text"  name="mobile" value=""
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
                                <input type="password" name="password" placeholder="گذرواژه خود را وارد نمائید">
                                <div class="error_field text-danger"></div>
                            </div>
                            <div class="col-sm-6 pt-4">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="remember">
                                    <div class="error_field text-danger"></div>

                                    <span class="checkmark"></span>
                                    مرا بخاطر بسپار
                                </label>
                            </div>
                            <div class="col-sm-6 text-center pt-4">
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


<script src="{{ asset($path_user.'js/bootstrap.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset($path_user.'js/jquery-migrate.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset($path_user.'js/slick.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset($path_user.'js/theme-scripts.js').'?ver='.$ver}}"></script>
<script src="{{asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

<script>
    $(document).on('submit','.ajax_validate',function(e){
        // console.log(1)
        e.preventDefault();//Prevent from submitting

        submiter($(this))
    })


    function success(response) {
        $('.error_field').text('');

        var result =response.data
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
                        swal("", result.msg, result.color);
                        $(".swal2-confirm").click(function () {
                            window.location.replace(url);
                        });
                        return;
                    } else if (result.mode === "toastr") {
                        toastr[result.color](result.msg);
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

        form.find('input[type="file"]').each(function() {
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
            console.log(response)
            //must get( message , title , action   , link)
            success(response)

        }).catch(function (errors) {
            $('.error_field').text('');
            $.each(errors.response.data.errors, function (key, val) {
                validate(key, val,form)

            });
        });
    }

    function validate(key, val,form) {
        let input =form.find("." + key);
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
            icon: title==='خطا'?"error":"success",
            title: title,
            showCloseButton: false,

            buttons: {
                confirm: "تایید",
            },
        });
    }

    function toast(title, message,color='rgb(0, 255, 184)') {
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
            onClosed: function (instance, toast, closedBy,on_closed) {
                if(on_closed){
                    $('.close-modal').click();
                    location.reload();
                }
            },
            iconColor: 'rgb(0, 255, 184)'
        });
    }

</script>

</body>
</html>

