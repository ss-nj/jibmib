<div class="modal fade" id="approve-shop-modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">بررسی</h4>
                <button type="button" class="close"
                        data-dismiss="modal">

                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
                <form action="" method="post" class="ajax_validate approve_shop_form">
                    @csrf

                    <div class="row deny_shop-aria" style="display: none">
                    <textarea class="form-control reason"
                              name="reason" cols="40" required
                              placeholder="دلیل رد "
                              rows="5"></textarea>
                        <input type="hidden" name="approve" value="0">
                        <button type="submit" name="approve" value="0" class="btn btn-warning approve_shop_form_bot">ثبت رد
                        </button>

                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <form action="" method="post" class="ajax_validate approve_shop_form">
                    @csrf
                    <input type="hidden" name="approve" value="1">
                    <button type="submit" name="approve" value="1" class="btn btn-success approve">تایید</button>
                </form>
                <button type="button" class="btn btn-warning deny_shop">رد</button>

                <button type="button"
                        class="btn btn-rounded btn-danger close-modal"
                        data-dismiss="modal">کنسل
                </button>
            </div>
        </div>
    </div>
</div>

@push('internal_js')
    <script>
        $(document).on('click', '.deny_shop', function (e) {
            $(this).hide();
            $('.deny_shop-aria').show();

        })
        $(document).on('click', '.approve_shop_form_bot', function (e) {
            // $(this).hide();
            $('.deny_shop-aria').hide();
            $('.deny_shop').show();

        })
    </script>
@endpush
