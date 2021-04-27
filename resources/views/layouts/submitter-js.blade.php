<script>
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
    $(document).on('submit','.ajax_validate',function(e){
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

            //must get( message , title , action   , link)
            success(response)

        }).catch(function (errors) {
            if(errors.response.status===404)
            {
                sendMessage('خطا','مورد پیدا نشد');
            }
            $('.error_field').text('');
            $.each(errors.response.data.errors, function (key, val) {
                toast('خطا',val[0])
                validate(key, val,form)

            });
        });
    }

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

    function validate(key, val,form) {
        let input =form.find("." + key);
        console.log(input)

        input.addClass('is-invalid');
        input.next(".error_field").text(val[0]);

        // setTimeout(function () {
        //     input.removeClass("is-invalid");
        // }, 10000)
    }
</script>
