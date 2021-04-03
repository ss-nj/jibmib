<!DOCTYPE HTML>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>
        {{trim($siteSettings['site_name']->value_fa)}}| @yield('title')
    </title>
    <meta property="og:title" content=" {{trim($siteSettings['site_name']->value_fa)}}| @yield('title')"/>
    @hasSection ('seo')
        @yield('seo')
    @else
        <meta property="og:description" content=" {!! trim($siteSettings['site_description']->value_fa) !!}"/>

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
        <meta name="twitter:description" content="{!! trim($siteSettings['site_description']->value_fa) !!}"/>
        <meta name="twitter:site" content="@"/>
        <meta name="twitter:image"
              content="@yield('image')"/>
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/skel.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/style-xlarge.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/iziToast/dist/css/iziToast.min.css')}}" rel="stylesheet" type="text/css"/>


    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <style>

        .swal-text {
            text-align: center;
        }


        .select2-results__option--highlighted {
            background-color: #c6c6c6 !important;
        }
    </style>

    @yield('style')
    @stack('style')
    @stack('internal_css')
    @stack('external_css')


</head>
<body dir="rtl" id="top" style="text-align: right">

<!-- Header -->
@include('layouts.header')
@yield('content')

<!-- Footer -->
@include('layouts.footer')

<script src="{{asset('js/html5shiv.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/skel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/skel-layers.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/init.js')}}" type="text/javascript"></script>
     <script src="{{asset('js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>
<!-- Plugins -->
{{--<script src="{{asset($path.'assets/js/vendor/owl.carousel.min.js')}}" type="text/javascript"></script>--}}
{{--<script src="{{asset($path.'assets/js/vendor/jquery.fancybox.min.js')}}" type="text/javascript"></script>--}}
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

<script src="{{asset('js/axios.min.js') }}"></script>
<script src="{{ asset('plugins/iziToast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/theia-sticky-sidebar.min.js') }}"></script>
<script src="{{ asset('js/ResizeSensor.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"
        integrity="sha512-9pGiHYK23sqK5Zm0oF45sNBAX/JqbZEP7bSDHyt+nT3GddF+VFIcYNqREt0GDpmFVZI3LZ17Zu9nMMc9iktkCw=="
        crossorigin="anonymous"></script>

@stack('internal_js')
@stack('external_js')
@yield('script')
@yield('scripts')
<script>


    $('.select2').select2({
        placeholder: "یک یا چند تا از موارد زیر را انتخاب کنید",
        // tags: true,
        width: "100%",// just for stack-snippet to show properly
        multiple: true,
        // tokenSeparators: [',', ' '],
        dir: "rtl",
        language: "fa",
        // placeholder: 'موارد جدید را اضافه کنید',
        searching: function () {
            return "در حال جستجو"
        },
        searchInputPlaceholder: 'جستجو'

    });

    $('.single-select2').select2({
        placeholder: "یکی از موارد زیر را انتخاب کنید",
        // tags: true,
        width: "100%",// just for stack-snippet to show properly
        multiple: false,
        dir: "rtl",
        language: "fa",
        searching: function () {
            return "در حال جستجو"
        },
        searchInputPlaceholder: 'جستجو'

    });
    $('.single-select2').select2().on('select2:open', function (e) {
        $('.select2-search__field').attr('placeholder', 'جستجو');
    })

    function toast(title, message) {

        color = 'rgb(0, 255, 184)';
        time = time || 5000;
        iziToast.show({
            id: 'haduken',
            theme: 'dark',
            icon: 'icon-contacts',
            title: title,
            timeout: time,
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
            onClosed: function (instance, toast, closedBy) {
                // console.info('Closed | closedBy: ' + closedBy);
            },
            iconColor: 'rgb(0, 255, 184)'
        });
    }


    @if ($message = Session::get('alert_title'))
    sendMessage('{{ Session::get('alert_title')}}', '{{Session::get('alert_body')}}')

    @endif
    @error('alert_title')
    sendMessage('{{$errors->first('alert_title')}}', '{{$errors->first('alert_body')}}')

    @enderror

    @if(session()->has('logout'))

    sendMessage('خطا', '{{ session()->get('logout') }}')

    @endif

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



    // Add event trigger for change to textareas with limit
    $(document).on("input", "textarea[word-limit=true]", function () {


        // Get individual limits
        thisMin = parseInt($(this).attr("min-words"));
        thisMax = parseInt($(this).attr("max-words"));

        // Create array of words, skipping the blanks
        var removedBlanks = [];
        removedBlanks = $(this).val().split(/\s+/).filter(Boolean);

        // Get word count
        var wordCount = removedBlanks.length;

        // Remove extra words from string if over word limit
        if (wordCount > thisMax) {

            // Trim string, use slice to get the first 'n' values
            var trimmed = removedBlanks.slice(0, thisMax).join(" ");

            // Add space to ensure further typing attempts to add a new word (rather than adding to penultimate word)
            $(this).val(trimmed + " ");

        }


        // Compare word count to limits and print message as appropriate
        if (wordCount < thisMin) {

            $(this).parent().children(".writing_error").text("حداقل تعداد کلمات " + thisMin + ".");

        } else if (wordCount > thisMax) {

            $(this).parent().children(".writing_error").text("حداکثر تعداد کلمات " + thisMax + ".");

        } else {

            // No issues, remove warning message
            $(this).parent().children(".writing_error").text("");

        }

    });

    function textCounter(el, minlimit, maxlimit) {
        var len = el.value.length;

        // if (len >= maxlimit){
        // event.preventDefault();
        // } else{
        // $(el).closest( '.count_hint_field').text ( 'تعداد کلمات باقی مانده ' + (maxlimit - len-1));
        $(el).parent().children(".count_hint_field").text('تعداد کلمات باقی مانده :' + (maxlimit - len));

        // }
    }


    function copyLinkFunction(text) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val(text).select();
        document.execCommand("copy");
        temp.remove();

    }
</script>
</body>
</html>
