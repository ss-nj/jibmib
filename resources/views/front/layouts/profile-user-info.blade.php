<div class="ticket-section card-section mt-5 p-5">

    <!-- _________________User Profile ________________________ -->
    <div class="title">پروفایل کاربری</div>
    <form class="mb-4 ajax_validate" method="post" action="{{route('profile.update',auth()->id())}}"
          enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-row">
            <div class="form-group col-md-12">

                <label for="ajaxName" class="form-control-label">تصویر کاربر:</label>
                <img style="width: 30%" src="{{asset(\Illuminate\Support\Facades\Auth::user()->image->path)}}" class="output"/>

                <div class="form-group">

                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled
                               required
                               placeholder="انتخاب فایل">
                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                    type="button">انتخاب فایل</button>
                                            </span>

                    </div>
                    <input type="file"
                           name="avatar"
                           id="main_image"
                           class="file-upload-default main_image"
                           style="display: none"
                           onchange="loadFile(event)"
                           accept=" .gif, .jpg, .png">

                    <div class="error_field text-danger"></div>
                </div>

            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="first-name">نام</label>
                <input type="text" class="form-control  first_name" id="first-name" name="first_name" placeholder="نام"
                value="{{auth()->user()->first_name}}">
                <div class="error_field text-danger"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="last-name">نام خانوادگی</label>
                <div class="error_field text-danger"></div>
                <input type="text" class="form-control last_name" id="last-name" name="last_name"
                       value="{{auth()->user()->last_name}}"   placeholder="نام خانوادگی">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail">پست الکترونیک</label>
                <div class="error_field text-danger"></div>
                <input type="email" class="form-control email" id="inputEmail" name="email" placeholder="پست الکترونیک"
                       value="{{auth()->user()->email}}">
            </div>


        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="theme-btn green-btn">ذخیره</button>
        </div>
    </form>

{{--    <!-- _________________User Password ________________________ -->--}}
{{--    <div class="title">تغییر کلمه عبور</div>--}}
{{--    <form class="mb-4 ajax_validate" method="post" action="" enctype="multipart/form-data">--}}
{{--        @csrf--}}
{{--        <div class="form-row">--}}
{{--            <div class="form-group col-md-6">--}}
{{--                <label for="current-pass">کلمه عبور فعلی</label>--}}
{{--                <input type="password" class="form-control" id="current-pass">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-row">--}}
{{--            <div class="form-group col-md-6">--}}
{{--                <label for="new-pass">کلمه عبور جدید</label>--}}
{{--                <input type="password" class="form-control" id="new-pass">--}}
{{--            </div>--}}
{{--            <div class="form-group col-md-6">--}}
{{--                <label for="renew-pass">تکرار کلمه عبور جدید</label>--}}
{{--                <input type="password" class="form-control" id="renew-pass">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="d-flex justify-content-end">--}}
{{--            <button type="submit" class="theme-btn green-btn">تغییر کلمه عبور</button>--}}
{{--        </div>--}}
{{--    </form>--}}

{{--    <!-- _________________User Phone ________________________ -->--}}
{{--    <div class="title">تغییر شماره همراه</div>--}}
{{--    <form class="mb-4 ajax_validate" method="post" action="" enctype="multipart/form-data">--}}
{{--        @csrf--}}
{{--        <div class="form-row">--}}
{{--            <div class="form-group col-md-6">--}}
{{--                <input type="phone" class="form-control" id="phone-number" placeholder="شماره همراه خود را وارد نمایید">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="d-flex justify-content-end">--}}
{{--            <button type="submit" class="theme-btn green-btn">تغییر شماره همراه</button>--}}
{{--        </div>--}}
{{--    </form>--}}


</div>
@push('internal_js')
    <script>
        var loadFile = function (event) {
            var output = $('.output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

    </script>
@endpush
