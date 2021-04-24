<!DOCTYPE html>
<html dir="rtl" class="side-header">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    @include('shop.layouts.seo')



    @include('shop.layouts.styles')
    @stack('external_css')

    @stack('internal_css')
</head>
<body class="loading-overlay-showing" data-plugin-page-transition data-loading-overlay
      data-plugin-options="{'hideDelay': 500}">
{{--@include('shop.layouts.loader')--}}
<div class="body">

    @include('shop.layouts.header')
    <div role="main" class="main">
        @yield('content')
    </div>
    {{--     @include('shop.layouts.content')--}}
    @include('shop.layouts.footer')

</div>


@include('shop.layouts.scripts')
@stack('external_js')

@stack('internal_js')

<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-12345678-1', 'auto');
    ga('send', 'pageview');
</script>
 -->
<div class="modal fade hide" id="new-takhfif" tabindex="-1" role="dialog"
     aria-labelledby="formModalLabel" style=" padding-right: 15px;" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="formModalLabel">ایجاد تخفیف جدید</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('shop.takhfifs.store')}}" method="post" class="mb-4 ajax_validate">
                <div class="modal-body">

                    @csrf
                    <div class="form-group row align-items-center">
                        <label class="col-sm-3 text-left text-sm-right mb-0">عنوان تخفیف</label>
                        <div class="col-sm-9">
                            <input type="text" value="" class="form-control " name="name"
                                   aria-invalid="true">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-primary">ثبت تخفیف</button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
