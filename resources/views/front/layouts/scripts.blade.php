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
    $(document).on('submit','.ajax_validate',function(e){
        // console.log(1)
        e.preventDefault();//Prevent from submitting
// alert(1)
        submiter($(this))
    })


    function success(response) {
        $('.error_field').text('');

        var result =response.data
        if (result.status) {
            if (result.action) {
                if (result.action === "REFRESH") {
                    // location.reload();
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
        // alert(val[0])
        input.next(".error_field").text(val[0]);
        toast('خطا',val[0],'rgb(0, 255, 184)')
        // swal("", val[0]);

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
                }
            },
            iconColor: 'rgb(0, 255, 184)'
        });
    }

</script>
