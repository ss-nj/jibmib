<!DOCTYPE html>
<html lang="fa" direction="rtl" dir="rtl" style="direction: rtl">
<?php $path = 'assets/admin/' ?>

<!-- begin::Head -->
<style>
    body {
        font-family: IRANSans, sans-serif !important;
    }
    .select2-container {
        direction: ltr !important;
    }

    span.select2-container.select2-container--default.select2-container--open{
        direction: ltr;
    }
    .swal-text {
        text-align: center !important;
    }
</style>
<head>
    <meta charset="utf-8"/>

    <title >
         @yield('title')
    </title>
    <meta property="og:title" content=" {{trim($siteSettings['site_name']->value_fa)}}| @yield('title')"/>
    <meta property="og:description" content="
    @hasSection ('description')
    @yield('description')
    @else
    {{trim($siteSettings['site_description']->value_fa)}}
    @endif"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="fa"/>
    <meta property="og:site_name" content="{{trim($siteSettings['site_name']->value_fa)}}"/>
    <meta property="og:url"
          content=""/>
    @yield('image')
    <meta property="og:image"
          content="@yield('image')"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="{{trim($siteSettings['site_name']->value_fa)}}| @yield('title')"/>
    <meta name="twitter:description"
          content=" @hasSection ('description')
          @yield('description')
          @else
          {{trim($siteSettings['site_description']->value_fa)}}
          @endif"/>
    <meta name="twitter:site" content="@sheypoor"/>
    <meta name="twitter:image"
          content="@yield('image')"/>


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!--begin::Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->

    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('assets/fonts/iransans/css/all.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/main.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset($path.'plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset($path.'css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset($path.'css/skins/header/base/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset($path.'css/skins/header/menu/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset($path.'css/skins/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset($path.'css/skins/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css"/>
{{--    <link href="{{ asset('css/kamadatepicker.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{asset($path.'css/style-panel.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('material-design/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset($path.'css/jquery-confirm.css')}}" rel="stylesheet" type="text/css"/>
{{--    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>--}}


    <link href="{{asset('plugins/iziToast/dist/css/iziToast.min.css')}}" rel="stylesheet" type="text/css"/>
{{--    <link href="{{asset('plugins/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>--}}

    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
@yield('style')
@stack('css')
@stack('style')
@stack('external_css')
<!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}"/>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
    class=" kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">


<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{route('home')}}">
            {{--            <img alt="Logo" src="{{asset('assets/media/logos/logo-light.png')}}"/>--}}
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
            <span></span></button>
        <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></button>
    </div>
</div>

<!-- end:: Header Mobile -->

<!-- begin:: Page -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- begin:: Aside -->

    @include('panel.layouts.sidebar')

    <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

                <!-- begin:: Header Menu -->
                @include('panel.layouts.header-menu')


            </div>

            <!-- end:: Header -->
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- begin:: Content Head -->
{{--                <div class="kt-subheader  kt-grid__item" id="kt_subheader">--}}
{{--                </div>--}}

                <!-- end:: Content Head -->

                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                    <!--Begin::Dashboard 1-->

                    <!--Begin::Row-->
                @yield('content')

                <!--End::Row-->


                    <!--End::Dashboard 1-->
                </div>

                <!-- end:: Content -->
            </div>

            <!-- begin:: Footer -->
            <div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                <div class="kt-container  kt-container--fluid ">
{{--                    <div class="kt-footer__copyright">--}}
{{--                        2020&nbsp;&copy;&nbsp;<a href="http://keenthemes.com/metronic" target="_blank" class="kt-link">Keenthemes</a>--}}
{{--                    </div>--}}
{{--                    <div class="kt-footer__menu">--}}
{{--                        <a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">About</a>--}}
{{--                        <a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">Team</a>--}}
{{--                        <a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>--}}
{{--                    </div>--}}
                </div>
            </div>

            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Quick Panel -->

<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->


<!-- end::Sticky Toolbar -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };

</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{asset($path.'plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset($path.'js/scripts.bundle.js')}}" type="text/javascript"></script>
{{--<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>--}}
<script src="{{ asset('js/select2.js') }}"></script>

<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>

<script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
<script src="{{ asset('js/persian-date.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

<script src="{{ asset('js/master.js') }}"></script>
<script src="{{ asset('plugins/iziToast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/sortable.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset($path.'js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('js/file-upload.js') }}"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{asset($path.'js/pages/dashboard.js')}}" type="text/javascript"></script>

@stack('external_js')

@stack('js')
<script>
    $('.kt-select2').select2({
        tags: true,
        width: "100%" ,// just for stack-snippet to show properly
        multiple: true,
        tokenSeparators: [',', ' '],
        dir: "rtl",
        language: "fa",
        placeholder: 'موارد جدید را اضافه کنید',
        allowClear: true,

    });
</script>
<script>

    $('.select2').select2({
        multiple: false,
        placeholder: 'انتخاب کنید...',
        dir: 'rtl',
        allowClear: true,
    });
    @if ($message = Session::get('alert_title'))
    sendMessage('{{ Session::get('alert_title')}}', '{{Session::get('alert_body')}}')

    @endif
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


    function confirmDelete(element)
    {
        $('.token').val( $('meta[name="csrf-token"]').attr('content'));
        var form = $(element).closest('form');
        $(form).submit(function(e){
            e.preventDefault();
        });

        var r = confirm("آیا از حذف مطمئن هستید!");
        if (r == true) {
            $(form)[0].submit();
        } else {
            console.log('canceled');
        }

    }
    function textCounter(el,minlimit,maxlimit)
    {
        var len =  el.value.length;

        // if (len >= maxlimit){
        // event.preventDefault();
        // } else{
        // $(el).closest( '.count_hint_field').text ( 'تعداد کلمات باقی مانده ' + (maxlimit - len-1));
        $(el).parent().children(".count_hint_field").text('تعداد کلمات باقی مانده :' + (maxlimit - len));

        // }
    }
    $('.price_input').keyup(function () {
        console.log($(this).parent().find('.price_input').val())
        let price = parseInt($(this).parent().find('.price_input').val());
        if(isNaN(price)) {
            $(this).parent().find('.price-persian').text(0)
        }else {
            $(this).parent().find('.price-persian').text(englishNumber(price.toLocaleString('us',)))
        }
     });
    function englishNumber(value) {
        if (!value) {
            return;
        }
        var englishNumbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"],
            persianNumbers = ["۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", "۰"];

        for (var i = 0, numbersLen = englishNumbers.length; i < numbersLen; i++) {
            value = value.replace(new RegExp(englishNumbers[i], "g"), persianNumbers[i]);
        }
        return value;
    }

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
            swal("", result.msg, "success");
        } else {
            swal("", result.msg, "error");
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

    $(document).on('click', '.data_table_move', function () {
        var ajaxSortBy = $('#ajaxSortBy').val();
        var ajaxAscDesc = $('#ajaxAscDesc').val();

        if ((ajaxSortBy && ajaxSortBy !=='position' )|| (ajaxAscDesc && ajaxAscDesc !=='DESC')  ) {
            alert('لطفا فیلتر های جستجو را بر روی ترتیب و حالت نزولی تنظیم کنید');
            return
        }

        let id = $(this).data('id');
        let type = $(this).data('type');
        let table = $(this).data('table');
        let row = $('tr#dtrid_' + id);
        let position = null;
        let prev = row.prev();
        let next = row.next();

        if (type === 'moveAfter'&&prev.length > 0) {
            position = prev.attr('id').split('_')[1];
        }
        else if (type === 'moveBefore'&&next.length > 0) {
            position = next.attr('id').split('_')[1] ;
        }
        console.log(id, type, table, position)

        axios.post('{{route('panel.position')}}',
            {
                id:id, type:type, table:table, position:parseInt(position)
            },
        ).then(function (response) {
            //Success
            console.log(response)
            //must get( message , title , action   , link)
            success(response)

        }).catch(function (errors) {

        });
    })

</script>
@stack('scripts')
@stack('internal_js')
@yield('script')

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
