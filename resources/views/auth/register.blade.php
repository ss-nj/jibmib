@extends('layouts.master')

@section('content')

    <section id="overview" class="section custom-bg-color-1 custom-background-style-1 m-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">ثبت نام</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.register') }}" class="ajax_validate">
                                @csrf
                                @include('messages.error-validation')
                                <div class="form-group row">
                                    <label class="control-label"><i class="mdi mdi-cellphone-android "></i>شماره تلفن همراه</label>

                                    <div class="col-md-6">
                                        <input type="tel" class="form-control mobile"
                                               id="mobile" name="mobile"
                                               maxlength="11" minlength="10"
                                               title="شماره تلفن همراه"
                                               oninvalid="setCustomValidity('شماره موبایل را به صورت صحیح وارد کنید.')"
                                               onchange="try{setCustomValidity('')}catch(e){}"
                                               pattern="^09[0-9]{9}$"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
                                               placeholder="شماره موبایل را به صورت صحیح وارد کنید." required>
                                        <div class="error_field text-danger"></div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="password-field"><i class="mdi mdi-key"></i> گذرواژه</label>
                                    <input type="password" name="password" id="password" maxlength="20" minlength="6"
                                           required
                                           title="  گذرواژه"
                                           oninvalid="setCustomValidity('وارد کردن گذرواژه الزامی است گذرواژه باید بین 6 تا 20 کاراکتر باشد')"
                                           onchange="try{setCustomValidity('')}catch(e){}"
                                           class="col-md-6 form-control password"
                                           placeholder="گذرواژه">
                                    <div class="error_field text-danger"> </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"><i class="mdi mdi-key"></i> تکرار گذرواژه</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" maxlength="20"
                                           minlength="6" required
                                           title=" تکرار گذرواژه"
                                           oninvalid="setCustomValidity('وارد کردن تکرار گذرواژه الزامی است')"
                                           onchange="try{setCustomValidity('')}catch(e){}"
                                           class="col-md-6 form-control password_confirmation"
                                           placeholder="تکرار گذرواژه">
                                    <div class="error_field text-danger"></div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            ثبت نام
                                        </button>
                                        <div class="form-group">


                                            <input class="form-check-input" type="checkbox" name="rules" required
                                                   oninvalid="setCustomValidity('موافقت با قوانین سایت اجباری می باشد ')"
                                                   onchange="try{setCustomValidity('')}catch(e){}"
                                                   id="rules" {{ old('remember') ? 'checked' : '' }} style="display: block">

                                            <label class="form-check-label" for="rules">
                                                با <a class="link-for-register">قوانین سایت</a> موافقم
                                            </label></div>


                                    </div>
                                    <span>
                                 قبلا عضو شده اید <a href="{{route('login.form')}}" class="btn btn-link">اینجا</a> کلیک کنید
                            </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>    </section>

@endsection

