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
            <form method="POST" action="{{ route('refunds.store') }}" class="ajax_validate">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shop_id">فروشگاه</label>

                        <select name="shop_id" title="فروشگاه" class="form-control select2" style="width: 100%">
                            <oprtion ></oprtion>
                        </select>
                        <div class="error_field text-danger">  </div>
                    </div>
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
                        <label for="description">توضیحات</label>

                        <textarea name="description" class="form-control description" cols="30" rows="10"></textarea>
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


