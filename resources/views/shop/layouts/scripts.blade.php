<!-- Vendor -->
<script src="{{asset($path.'vendor/jquery/jquery.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.appear/jquery.appear.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.easing/jquery.easing.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.cookie/jquery.cookie.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/popper/umd/popper.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/bootstrap/js/bootstrap.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/common/common.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.validation/jquery.validate.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.gmap/jquery.gmap.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/jquery.lazyload/jquery.lazyload.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/isotope/jquery.isotope.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/owl.carousel/owl.carousel.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/magnific-popup/jquery.magnific-popup.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/vide/jquery.vide.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/vivus/vivus.min.js?ver='.$ver)}}"></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('plugins/select2/fa.min.js') }}"></script>

<!-- Theme Base, Components and Settings -->
<script src="{{asset($path.'js/theme.js?ver='.$ver)}}"></script>

<!-- Current Page Vendor and Views -->
<script src="{{asset($path.'vendor/rs-plugin/js/jquery.themepunch.tools.min.js?ver='.$ver)}}"></script>
<script src="{{asset($path.'vendor/rs-plugin/js/jquery.themepunch.revolution.min.js?ver='.$ver)}}"></script>

<!-- Theme Custom -->
<script src="{{asset($path.'js/custom.js?ver='.$ver)}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset($path.'js/theme.init.js?ver='.$ver)}}"></script>

<!-- Examples -->
<script src="{{asset($path.'js/examples/examples.portfolio.js?ver='.$ver)}}"></script>
<script src="{{ asset('js/file-upload.js') }}"></script>
<script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
<script src="{{ asset('js/persian-date.min.js') }}"></script>
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
            if (result.function) {
                // console.log(result.args.toString())
                // window[result.function](result.args.toString());
                window[result.function].apply( window, result.args.toString().split(',') )

            }
            if (result.action) {

                if (result.action === "REFRESH") {
                    location.reload();
                    return;
                }
                if (result.action === "DATATABLE_REFRESH") {
                    $('.modal').modal('hide')

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
        // console.log(formData)
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
        // console.log(input)
        // alert(key);
        input.addClass('is-invalid');
        input.next(".error_field").text(val[0]);

        // setTimeout(function () {
        //     input.removeClass("is-invalid");
        // }, 10000)
    }

    $('.select2').select2({
        placeholder: "یک یا چند تا از موارد زیر را انتخاب کنید",
        // tags: true,
        width: "100%",// just for stack-snippet to show properly
        // multiple: true,
        // tokenSeparators: [',', ' '],
        dir: "rtl",
        language: "fa",
        // placeholder: 'موارد جدید را اضافه کنید',
        // searching: function () {
        //     return "در حال جستجو"
        // },
        // searchInputPlaceholder: 'جستجو'
    });
    $('.select2-multiple').select2({
        placeholder: "یک یا چند تا از موارد زیر را انتخاب کنید",
        // tags: true,
        width: "100%",// just for stack-snippet to show properly
        multiple: true,
        // tokenSeparators: [',', ' '],
        dir: "rtl",
        language: "fa",
        // placeholder: 'موارد جدید را اضافه کنید',
        // searching: function () {
        //     return "در حال جستجو"
        // },
        // searchInputPlaceholder: 'جستجو'
    });

</script>

<script>
    $(document).ready(function () {

        var to, from;
        to = $(".range-to-example").persianDatepicker({
            inline: false,
            // initialValueType: 'gregorian',
            observer: true,
            format: 'YYYY-MM-DD-H:mm',
            initialValue: false,
            onSelect: function (unix) {
                to.touched = true;
                $('#view_end_time').trigger('change');

                if (from && from.options && from.options.maxDate != unix) {
                    var cachedValue = from.getState().selected.unixDate;
                    from.options = {maxDate: unix};
                    if (from.touched) {
                        from.setDate(cachedValue);

                    }
                }
            }
        });
        from = $(".range-from-example").persianDatepicker({
            inline: false,
            // initialValueType: 'gregorian',
            observer: true,
            format: 'YYYY-MM-DD-H:mm',
            initialValue: false,
            onSelect: function (unix) {
                $('#view_start_time').trigger('change');

                from.touched = true;
                if (to && to.options && to.options.minDate != unix) {
                    var cachedValue = to.getState().selected.unixDate;
                    to.options = {minDate: unix};
                    if (to.touched) {
                        to.setDate(cachedValue);

                    }
                }
            }
        });

    });
</script>

<script>
    $('.price_input').keyup(function () {
        // alert($(this).val())
        let price = parseInt($(this).val());

        if (isNaN(price)) {
            $(this).parent().find('.price-persian').text(0)
        } else {
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
</script>

<script>
    function deleteWithModal(form, id, e) {
        e.preventDefault();
        swal("آیا اطمینان دارید؟", {
            dangerMode: true,
            buttons: true,
            icon: "warning",
            title: "اخطار!",

        })
            .then((willDelete) => {
                if (willDelete) {
                    // let formDelete = form + id;
                    // submiter(document.getElementById(formDelete));
                    let formDelete = form + id;
                    submiter($( document.getElementById(formDelete)));
                    // document.getElementById(formDelete).submit();
                } else {
                    swal("حذف شما لغو گردید!");
                }
            });
    }

</script>
