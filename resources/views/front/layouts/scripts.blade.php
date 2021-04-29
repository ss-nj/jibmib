<script src="{{asset($path_user.'js/jquery.min.js').'?ver='.$ver}}"></script>
<script src="{{asset('plugins/leaflet/leaflet.js')}}"></script>
<script src="{{asset('assets/js/vendor/popper.min.js')}}"></script>
<script src="{{asset($path_user.'js/bootstrap.min.js').'?ver='.$ver}}"></script>
<script src="{{asset($path_user.'js/jquery-migrate.min.js').'?ver='.$ver}}"></script>
<script src="{{asset($path_user.'js/slick.min.js').'?ver='.$ver}}"></script>
<script src="{{asset($path_user.'js/theme-scripts.js').'?ver='.$ver}}"></script>
<script src="{{asset($path_user.'js/jquery-backward-timer.min.js').'?ver='.$ver}}"></script>
<script src="{{ asset('js/file-upload.js') }}"></script>



{{--    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>--}}
<script src="{{asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('plugins/iziToast/dist/js/iziToast.min.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
{{--    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>--}}
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
{{--    <script src="{{ asset('plugins/sticky-sidebar/theia-sticky-sidebar.min.js') }}"></script>--}}
{{--    <script src="{{ asset('plugins/sticky-sidebar/ResizeSensor.min.js') }}"></script>--}}


@stack('external_js')
@stack('internal_js')
@yield('script')
@yield('scripts')
<script>

    // $(document).ready(function () {
    //     $("a").each(function(){
    //         if ($(this).attr("href") == window.location.pathname){
    //             $(this).parent('li').addClass('nav-active');
    //         }
    //     });
    // })
    // $('.leftSidebar, .rightSidebar').theiaStickySidebar();

    function toast(title, message) {

        color = 'rgb(0, 255, 184)';
        time = 5000;
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



    function sendMessage(title, message) {
        swal(message, {
            dangerMode: false,
            icon: title === 'خطا' ? "error" : "susuccess",
            title: title,
            showCloseButton: false,

            buttons: {
                confirm: "تایید",
            },
        });
    }


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

<script>

    $(document).ready(function () {
        $(document).on('click','.remove-from-cart', function (e) {
            e.preventDefault();
            $('.remove-from-cart').attr('disabled', 'true');
            $('#page-overlay').css('display', 'block');
            $('.spinner').css('display', 'block');

            let id = $(this).attr('data-id');
            $.ajax({
                type: 'get',
                url: '{{ url('remove-from-cart') }}',
                data: {
                    'id': id
                },
                success: function (response) {
                    if (response.success) {
                        let toast_message = ' با موفقیت حذف شد .';
                        sendMessage('موفق', toast_message);
                        refreshcart()

                    } else {
                        let toast_message = response.error;
                        sendMessage('خطا', toast_message);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 404) {
                        var toast_message = 'مورد پیدا نشد .';
                        sendMessage('خطا', toast_message);
                    }
                }
            }).always(function () {
                $('#page-overlay').css('display', 'none');
                $('.spinner').css('display', 'none');
            });
        })

    });
</script>
<script>
    $(document).on('input change keyup past propertychange', '.only_en_numbers', function () {

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
        this.value = this.value.replace(/(\..*)\./g, '$1');

    })
</script>
@include('layouts.submitter-js')

