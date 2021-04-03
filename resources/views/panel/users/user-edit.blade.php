<form action="{{ route('users.update', $user->id) }}" method="post" autocomplete="off"
      class="ajax_validate"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">{{__('users.edit')}} <span
                    class="text-danger">{{ $user->name }}</span></h4>
            <button type="button" class="close" data-dismiss="modal">

            </button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <input style="display:none">
            <div class="row mb-2">

                <label for="image"
                       class="col-md-3">اضافه کردن تصویر</label>
                <div class="col-md-6">
                    <input type="file" class="form-control image"
                           accept=" .gif, .jpg, .png"
                           name="main_image">
                </div>
                <div class="col-md-3 product-image">
                    @if($user->image->path!==\App\Http\Core\Models\Image::NO_IMAGE_PATH)
                        <div
                            class="container">
                            <img
                                src="{{url($user->image->path) }}"
                                class="img-account img-radius image"
                                style="width:40px;height: 40px">
                            <div
                                class="middle">
                                <button
                                    type="button"
                                    class="text btn-sm btn-rounded btn-danger remove-image"
                                    data-id="{{$user->image->id}}">
                                    حذف
                                    تصویر
                                </button>
                            </div>

                        </div>
                    @endif
                </div>
                <div class="error_field text-danger"> </div>
            </div>

            <div class="row mt-6">
                <div class="col-md-6">
                    <label for="first_name">نام</label>

                    <input type="text"
                           class="form-control first_name"
                           name="first_name"
                           id="first_name"
                           value="{{ $user->first_name }}"
                           placeholder="نام">
                    <div class="error_field text-danger"> </div>

                </div>
                <div class="col-md-6">
                    <label>نام خانوادگی</label>

                    <input type="text"
                           class="form-control"
                           name="last_name"
                           id="last_name"
                           value="{{$user->last_name}}"

                           placeholder="نام خانوادگی"/>
                    <div class="error_field text-danger"> </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <label>گذرواژه</label>

                    <input type="password"
                           class="form-control password" value=""
                           name="password" id="password" autocomplete="new-password"
                    >
                    <div class="error_field text-danger"> </div>

                </div>
                <div class="col-md-6">
                    <label>تایید گذرواژه</label>

                    <input type="password password_confirmation"
                           class="form-control "
                           name="password_confirmation"
                           id="password_confirmation"
                           placeholder="تایید گذرواژه"
                    >
                    <div class="error_field text-danger"> </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label>کیف پول</label>

                    <input type="number" class="form-control wallet" pattern="\d*" maxlength="7"
                           placeholder="کیف پول"
                           value="{{$user->wallet}}" autocomplete="off"
                           name="wallet"
                           id="wallet"
                    />
                    <div class="error_field text-danger"> </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label>آدرس</label>


                    <textarea name="address"
                              class="form-control address"
                              maxlength="1000"
                              placeholder="آدرس کاربر" minlength="10" cols="30"
                              rows="4">{{$user->address}}</textarea>
                    <div class="error_field text-danger"></div>

                </div>
            </div>


            <div class="row">
                <label>سمت</label>

                <select multiple name="roles[]"
                        class="form-control select2 roles">

                    @if($roles)
                        @foreach($roles as $role)
                            <option
                                value="{{$role->id}}"
                                {{ in_array($role->id ,$user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{$role->display_name}}
                            </option>
                        @endforeach
                    @endif
                </select>
                <div class="error_field text-danger"> </div>

            </div>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-rounded btn-success">
                ویرایش
            </button>
            <button type="button" class="btn btn-rounded btn-danger close-modal"
                    data-dismiss="modal">انصراف
            </button>
        </div>
    </div>
</form>
<script>
    $('.select2').select2({
        placeholder: 'انتخاب کنید...',
        dir: 'ltr',
        allowClear: true,
    });
</script>

