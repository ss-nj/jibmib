<form action="{{ route('category.update', $category->id) }}" method="post"
      class="ajax_validate"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">ویرایش دسته <span
                        class="text-danger">{{ $category->name }}</span></h4>
            <button type="button" class="close" data-dismiss="modal">

            </button>
        </div>
        <div class="error_field text-danger"> </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="is_menu" class="form-control-label"> نمایش در عنوان منو :</label>

                <div class="checkbox col-xs-10 col-xs-offset-1 mt-10">
                    <input type="hidden" name="is_menu" value="0" >
                    <input type="checkbox" name="is_menu" id="is_menu" {{$category->is_menu?'checked':''}} value="1">
                    <label class="control-label" for="is_menu"> نمایش در عنوان منو </label>
                </div>
                <div class="error_field text-danger"> </div>
            </div>
            <div class="form-group">
                <label for="name" class="form-control-label">نام دسته بندی :</label>
                <input type="text" class="form-control name" id="name" name="name" minlength="5"
                       title="نام دسته بندی "
                       value="{{ $category->name }}"
                >
                <div class="error_field text-danger"> </div>
            </div>
             <div class="form-group">
                <label for="icon" class="form-control-label">  ایکن دسته بندی :   <a target="_blank" href="https://iconify.design/icon-sets/fa/">مقدار را از اینجا انتخاب کنید</a></label>
                <input type="text" class="form-control icon" id="icon" name="icon" minlength="5"
                       title="ایکن دسته بندی "
                       value="{{ $category->icon }}"
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
                       value="{{ $category->slug }}"
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
                <img style="width: 100%;max-height: 200px" src="{{asset($category->image->path!=\App\Http\Core\Models\Image::NO_IMAGE_PATH?$category->image->path:"")}}" id="output"/>
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label">توضیحات :</label>
                <textarea class="form-control" id="description" name="description" cols="30"
                          rows="5">{{ $category->description }}</textarea>
                <span class="invalid-feedback description_error" role="alert"></span>

            </div>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
            <button type="submit" class="btn btn-primary">ویرایش دسته بندی</button>
        </div>
    </div>
</form>

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


