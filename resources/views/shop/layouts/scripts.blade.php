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
<script src="{{ asset('plugins/iziToast/dist/js/iziToast.min.js') }}"></script>

@include('layouts.submitter-js')

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

<script>


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
                    let formDelete = form + id;
                    submitter($( document.getElementById(formDelete)));
                    // document.getElementById(formDelete).submit();
                } else {
                    swal("حذف شما لغو گردید!");
                }
            });
    }

</script>
