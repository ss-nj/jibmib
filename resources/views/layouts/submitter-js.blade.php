<script>
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

    $(document).on('submit', '.ajax_validate', function (e) {
        // console.log(1)
        e.preventDefault();//Prevent from submitting

        submitter($(this))
    })

    function submitter(form) {
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

            switch (errors.response.status) {
                case 404:
                    sendMessage('خطا', 'مورد پیدا نشد');
                    break;
                case 419:
                    sendMessage('خطا', 'شما دسترس لازم را ندارید یا ورود شما باطل شده است لطفا صفحه را دوباره بارگزاری کنید و یا به ساین وارد شوید');
                    break;
                case 422: {
                    $('.error_field').text('');
                    $.each(errors.response.data.errors, function (key, val) {
                        toast('خطا', val[0])
                        validate(key, val, form)
                    });
                }
                    break;
                case 429:
                    sendMessage('خطا', 'تعداد تلاشهای ناموفق شما از تعداد مجاز بیشتر شده است . لطفا چند دقیقه ی دیگر تلاش کنید .');
                    break;
                default:
                    sendMessage('خطا', 'مشکلی پیش آمده لطفا صفحه را رفرش کنید و در صورت ادامه مشکل با پشتیبانی تماس بگیرید');
            }

        });
    }

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
                if (result.action === "SHOW_AND_REFRESH") {
                    swal(result.title, result.message, result.color);
                    $(".swal-button--confirm").click(function () {
                        location.reload();
                        return;
                    });
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
            swal("", result.message, "success");
        } else {
            swal("", result.message, "error");
        }
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
</script>
