<div class="modal fade" id="new-place" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافه کردن منطقه جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('places.store') }}" class="ajax_validate">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="mobile">نام</label>

                        <input type="text"
                               class="form-control name"
                               name="name"
                               id="name"
                               autocomplete="name" autofocus
                               placeholder="نام">
                        <div class="error_field text-danger">  </div>
                    </div>

                    <div class="form-group">
                        <label for="slug">نامک(قسمت انتهایی لینک صفحه)</label>

                        <input type="text"
                               class="form-control slug"
                               name="slug"
                               id="slug"
                               autocomplete="slug" autofocus
                               placeholder="نامک(قسمت انتهایی لینک صفحه)"/>
                        <div class="error_field text-warning">
                           <h6>نامک بعد از ذخیره ممکن است تغییر کند!! (حدف موارد غیر مجاز)</h6>
                        </div>
                        <div class="error_field text-danger">  </div>
                    </div>


                    <div class="form-group" >
                        <label for="mobile">استان</label>

                        <select class="form-control select2 select-province province_id" style="width: 100%"
                                title="استان را انتخاب کنید"
                                 name="province_id" id="province_id">
                        </select>
                        <div class="error_field text-danger"></div>

                    </div>

                    <div class="form-group">
                        <label for="select-city">شهرها</label>

                        <select class="form-control select2 select-city city_id" style="width: 100%"
                                title="شهر را انتخاب کنید"
                                 name="city_id" id="city_id">
                        </select>
                        <div class="error_field text-danger">
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ایجاد منطقه</button>
                </div>
            </form>

        </div>
    </div>
</div>


