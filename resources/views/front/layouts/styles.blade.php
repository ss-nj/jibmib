<script>
    window.addEventListener("pageshow", function (event) {
        var historyTraversal = event.persisted ||
            (typeof window.performance != "undefined" &&
                window.performance.navigation.type === 2);
        if (historyTraversal) {
            // Handle page restore.
            // window.location.reload();
            refreshcart();
        }
    });


    function refreshcart() {

        $('#page-overlay').css('display', 'block');
        $('.spinner').css('display', 'block');

        $.ajax({
            type: 'get',
            url: '{{ url('refresh-cart') }}',
            success: function (response) {
                if (response.success) {
                    $('.shop-cart').empty();
                    $('.shop-cart').append(response.view);
                    // var toast_message = ' سبد خرید تغییر کرد.';
                    // toast("موفق", toast_message);
                    if (response.basket){
                        $('#user-basket').empty();
                        $('#user-basket').append(response.basket);


                        $('.basket-total_discount').text(englishNumber(response.total_discount.toLocaleString('us')) );
                        $('.basket-totalPrice_no_dis').text(englishNumber( response.totalPrice_no_dis.toLocaleString('us')));
                        $('.basket-totalPrice').text(englishNumber(response.totalPrice.toLocaleString('us')));
                    }

                } else {

                }
            }
        }).always(function () {
            $('#page-overlay').css('display', 'none');
            $('.spinner').css('display', 'none');
        });

    }
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


<link rel="stylesheet" href="{{asset($path_user.'css/all.min.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'css/bootstrap.rtl.min.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'css/fontiran.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'css/slick.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'css/slick-theme.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'css/style.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'style.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset($path_user.'css/responsive-style.css').'?ver='.$ver}}" type='text/css' media='all'/>
<link rel="stylesheet" href="{{asset('css/iziToast/css/iziToast.min.css').'?ver='.$ver}}" type='text/css' media='all'/>


<style>
    #page-overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 10000;
        cursor: pointer;
    }
    .overlay-content {
        position: relative;
        top: 25%;
        width: 100%;
        text-align: center;
        margin-top: 30px;
    }
    .swal-text {
        text-align: center;
    }

     blockquote {
         padding: 10px 20px;
         margin: 0 0 20px;
         font-size: 18px;
         border-left: 5px solid #3d95d4;
         color: #3d95d4;
     }

    blockquote.alignright {
        max-width: 90%;
        float: right;
        color: #3d95d4;
        text-align: right;
        border-right: 5px solid #3d95d4;
        border-left: transparent;
    }

    blockquote.alignleft {
        max-width: 90%;
        float: left;
    }

    .carousel-item img {
        height: 339px !important;
    }

    .b {
        position: fixed;
        top: 20px;
    }

    .a {
        position: absolute;
        top: 230px;
    }

     .search-dropdown-menu{
         text-align: right;
         position: absolute;
         background-color: #fff;
         box-shadow: 0px 2px 11px 0px;
         padding: 16px;
         z-index: 9999999;
         width: 600px;
     }

     .mobile-search-dropdown-menu{
         text-align: right;
         position: absolute;
         background-color: #fff;
         box-shadow: 0px 2px 11px 0px;
         padding: 16px;
         z-index: 9999999;
         width: 90%;
     }

</style>

@yield('style')
@stack('style')
@stack('external_css')
@stack('internal_css')
