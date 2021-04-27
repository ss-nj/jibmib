<div class="modal fade" id="new-refund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافه کردن درخواست برداشت جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('shop.refund.store') }}" class="ajax_validate">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="amount">مقدار</label>

                        <input type="text"
                               class="form-control amount"
                               name="amount"
                               title="مقدار"
                               id="amount"
                               autocomplete="name" autofocus
                               placeholder="مقدار">
                        <div class="error_field text-danger">  </div>
                    </div>

                    <div class="form-group">
                        <label for="bank_id">شماره حساب</label>

                        <input type="text"
                               class="form-control bank_id"
                               name="bank_id"
                               title="شماره حساب"
                               id="bank_id"
                               autocomplete="bank_id" autofocus
                               placeholder="شماره حساب">
                        <div class="error_field text-danger">  </div>
                    </div>

                    <div class="form-group">
                        <label for="description">توضیحات</label>

                        <textarea name="description" class="form-control description" cols="30" rows="5"></textarea>
                        <div class="error_field text-danger">  </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ایجاد درخواست</button>
                </div>
            </form>

        </div>
    </div>
</div>


