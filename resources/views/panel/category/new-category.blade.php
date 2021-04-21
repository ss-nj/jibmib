<div class="modal fade" id="new-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافه کردن دسته بندی جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('category.store') }}" class="ajax_validate">
                @csrf
                <input type="hidden" name="category_id" value="{{isset($parent_category)?$parent_category->id:null}}">
                <div class="error_field text-danger"> </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="is_menu" class="form-control-label"> نمایش در عنوان منو :</label>

                        <div class="checkbox col-xs-10 col-xs-offset-1 mt-10">
                            <input type="hidden" name="is_menu" value="0" >
                            <input type="checkbox" name="is_menu" id="is_menu" class="is_menu" value="1">
                            <label class="control-label" for="is_menu"> نمایش در عنوان منو </label>
                        </div>
                        <div class="error_field text-danger"> </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">نام دسته بندی :</label>
                        <input type="text" class="form-control name" id="name" name="name" minlength="5"
                               title="نام دسته بندی "
                               >
                        <div class="error_field text-danger"> </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">  ایکن دسته بندی :   <a target="_blank" href="https://iconify.design/icon-sets/fa/">مقدار را از اینجا انتخاب کنید</a></label>
                        <input type="text" class="form-control icon" id="icon" name="icon" minlength="5"
                               title="ایکن دسته بندی "
                               value=" "
                        >
                        <div class="error_field text-danger"> </div>
                    </div>
                    <div class="form-group">
                        <label for="slug">نامک(قسمت انتهایی لینک صفحه) :</label>

                        <input type="text"
                               class="form-control slug"
                               name="slug"
                               id="slug"
                               title="نامک(قسمت انتهایی لینک صفحه)"
                               autocomplete="slug" autofocus
{{--                               placeholder="نامک"--}}
                        />
                        <div class="error_field text-warning">
                            <h6>نامک بعد از ذخیره ممکن است تغییر کند!! (حدف موارد غیر مجاز)</h6>
                        </div>
                        <div class="error_field text-danger"> </div>
                    </div>

                    <div class="form-group">

                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled

                                   placeholder="انتخاب فایل">
                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                    type="button">انتخاب فایل</button>
                                            </span>

                        </div>
                        <input type="file" name="main_image"  id="main_image" class="file-upload-default main_image"
                               style="display: none"
                               onchange="loadFile(event)"
                               accept=" .gif, .jpg, .png">
                        <div class="error_field text-danger"> </div>
                    </div>
                    <div class="portlet light row ">
                        <img style="width: 100%;max-height: 200px" id="output"/>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-control-label">توضیحات :</label>
                        <textarea class="form-control description" id="description" name="description" cols="30"
                                  rows="5"></textarea>
                        <span class="invalid-feedback description_error" role="alert"></span>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ایجاد دسته بندی</button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('internal_js')
    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

    </script>
@endpush
