<div id="edit-status" class="modal fade animate" data-backdrop="true">
    <div class="modal-dialog" id="animate">
        <form id="edit-status-form" action="" method="post" class="ajax_validate">
            {{ csrf_field() }}

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="row">ویرایش وضعیت ارسال (لطفا قبل از تغییر دفت کنید)</h5>
                    <h5 class="row">تمام تعییرات در تاریخچه ذخیره میشود</h5>
                </div>
                <div class="modal-body text-center p-lg">
                    <div class="row form-group" style="text-align: right;">
                        <label for="status" class="form-control-label col-md-3">وضعیت  :</label>
                        <div class="col-md-9">
                            <select name="status" id="status" class="form-control status" dir="rtl">
                                <option value="0">درانتظار بررسی</option>
                                <option value="1">تایید شده</option>
                                <option value="2">رد شده</option>
                                <option value="3">در حال بررسی</option>
                                <option value="4">پرداخت شده</option>
                            </select>
                            <div class="error_field text-danger"></div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn rounded btn-danger p-x-md close-modal" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn rounded btn-success p-x-md btn-sm">ثبت</button>
                </div>
            </div>
        </form>
    </div>
</div>
