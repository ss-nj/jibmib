<div class="row">
    <div class="col-sm-12 col-xs-12">
        <form action="{{ route('setting.update') }}" method="post" enctype="multipart/form-data"
              accept-charset="utf-8">
            {{ csrf_field() }}
            @foreach($settings as $setting)
                <div class="form-group col-md-12">
                    <label for="settings"> {{$setting->label}} </label>
                    @if($setting->type==='text')
                        <textarea name="settings[{{$setting->key}}]" cols="30" rows="10"
                                  maxlength="{{$setting->lenth_limit??''}}"
                                  class="form-control ck-editor">
                                        {!! $setting->value_fa !!}
                                        </textarea>
                    @elseif($setting->type === "logo")

                        <img src="{{ asset( $setting->value_fa)}}" alt="" style="width: 70px;height: auto">

                        <input class="form-control" id="settings[]" name="{{$setting->key}}" type="file"
                               accept="image/png, image/jpeg, image/svg">

                        <label class="form-control" for="val[]">انتخاب تصویر</label>

                    @elseif($setting->type === "file")

                        <a href="{{ asset( $setting->value_fa)}}"> دانلود {{$setting->label}}</a>
                        <input class="form-control" id="settings[]" name="{{$setting->key}}" type="file"
                        >

                        <label class="form-control" for="val[]">انتخاب فایل</label>

                    @elseif($setting->type === "money")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="10" {{ ($setting->value_fa == 10 ? "selected":"") }}>تومان</option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>ریال</option>

                            </select>
                        </div>

                    @elseif($setting->type === "user_fields")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="0" {{ ($setting->value_fa == 10 ? "selected":"") }}>غیر اجباری</option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>اجباری</option>

                            </select>
                        </div>

                    @elseif($setting->type === "register_sms")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="0" {{ ($setting->value_fa == 0 ? "selected":"") }}>بدون نیاز به ارسال
                                    پیامک
                                </option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>رمز زمان دار (120
                                    ثانیه)
                                </option>
                                <option value="2" {{ ($setting->value_fa == 2 ? "selected":"") }}>رمز بدون زمان</option>

                            </select>
                        </div>

                    @elseif($setting->type === "register_red_path")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="0" {{ ($setting->value_fa == 0 ? "selected":"") }}>خانه</option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>تنظیمات شخصی</option>
                                <option value="2" {{ ($setting->value_fa == 2 ? "selected":"") }}>سبد خرید</option>
                                <option value="3" {{ ($setting->value_fa == 3 ? "selected":"") }}>داشبورد</option>

                            </select>
                        </div>

                    @elseif($setting->type === "login_redirect_path")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="0" {{ ($setting->value_fa == 0 ? "selected":"") }}>خانه</option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>تنظیمات شخصی</option>
                                <option value="2" {{ ($setting->value_fa == 2 ? "selected":"") }}>سبد خرید</option>
                                <option value="3" {{ ($setting->value_fa == 3 ? "selected":"") }}>داشبورد</option>

                            </select>
                        </div>

                    @elseif($setting->type === "login_admin_redirect_path")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="0" {{ ($setting->value_fa == 0 ? "selected":"") }}>خانه</option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>تنظیمات شخصی</option>
                                <option value="2" {{ ($setting->value_fa == 2 ? "selected":"") }}>سبد خرید</option>
                                <option value="3" {{ ($setting->value_fa == 3 ? "selected":"") }}>داشبورد</option>
                                <option value="4" {{ ($setting->value_fa == 4 ? "selected":"") }}>داشبورد مدیریت
                                </option>
                            </select>
                        </div>

                    @elseif($setting->type === "login_redirect_intended")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control">
                                <option value="0" {{ ($setting->value_fa == 0 ? "selected":"") }}>خیر</option>
                                <option value="1" {{ ($setting->value_fa == 1 ? "selected":"") }}>بازگشت به آخرین صفحه
                                </option>

                            </select>
                        </div>

                    @elseif($setting->type === "home_category")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control select2">
                                <option >انتخاب کنید</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ ($category->id == $setting->value_fa ? "selected":"") }}>{{$category->name}}</option>
                                @endforeach

                            </select>
                        </div>

                     @elseif($setting->type === "home_takhfif")
                        <input type="hidden" name="settings[{{$setting->key}}]" value="{{$setting->id}}">

                        <div class="form-group">
                            <select name="settings[{{$setting->key}}]" class="form-control select2">
                                <option >انتخاب کنید</option>
                                @foreach($takhfifs as $takhfif)
                                    <option value="{{$takhfif->id}}" {{ ($takhfif->id == $setting->value_fa ? "selected":"") }}>{{$takhfif->name}}</option>
                                @endforeach

                            </select>
                        </div>

                    @else
                        <input type="text" name="settings[{{$setting->key}}]" maxlength="{{$setting->lenth_limit??''}}"
                               class="form-control" value="{{$setting->value_fa}}">
                    @endif
                    @error('settings')
                    <span class="invalid-feedback"
                          role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

            @endforeach


            <button type="submit"
                    class="btn btn-primary mr-2 btn-block ">ارسال
            </button>
        </form>
    </div>
</div>
