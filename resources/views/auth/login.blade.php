@extends('layouts.master')
<?php $path = 'thems/front/' ?>

@section('style')
    <style>
        body{
            background: url(images/bg1.jpg);
        }
        .swal-text {
            text-align: center;
        }
    </style>
@endsection

@section('title')
    ورود به سایت
@endsection

@section('header')
    <br>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row" dir="rtl">
            <div class="sign-form">
                <div class="form-logo">
                    <a href="{{route('home')}}">
                        <img src="{{asset($path."images/final-logo.png")}}" alt="Jibmib-logo">
                    </a>
                </div>


                <div id="login">
                    <form action="{{ route('user.login') }}" method="post" id="frm-user-login" class="ajax_validate">
                        <h3 class="header-form-Jibmib">ورود به سایت</h3>
                        @csrf
                        <div class="col-xs-12 form-group">
                            <label for="username"><i class="fa fa-user"></i> نام کاربری</label>
                            <input type="tel" class=" form-control" name="mobile" value="{{old('mobile')}}"
                                   maxlength="11" minlength="10"
                                   pattern="^09[0-9]{9}$"
                                   title="{{ old('mobile')?'':'شماره موبایل را به صورت صحیح وارد کنید.' }}"
                                   placeholder="شماره موبایل خود را وارد نمایید"

                                   oninput="
                           this.value = this.value.replace('۰', '0')  ;
                           this.value = this.value.replace('۱', '1')  ;
                           this.value = this.value.replace('۲', '2')  ;
                           this.value = this.value.replace('۳', '3')  ;
                           this.value = this.value.replace('۴', '4')  ;
                           this.value = this.value.replace('۵', '5')  ;
                           this.value = this.value.replace('۶', '6')  ;
                           this.value = this.value.replace('۷', '7')  ;
                           this.value = this.value.replace('۸', '8')  ;
                           this.value = this.value.replace('۹', '9')  ;
                           this.value = this.value.replace('٤', '4')  ;
                           this.value = this.value.replace('٥', '5')  ;
                           this.value = this.value.replace('٦', '6')  ;
                           this.value = this.value.replace(/[^0-9۰-۹.]/g, '');
                           this.value = this.value.replace(/(\..*)\./g, '$1');"
                            >
                            <div class="error_field text-danger"> </div>
                        </div>
                        <div class="col-xs-12 form-group">
                            <label for="password-field"><i class="mdi mdi-key"></i> گذرواژه</label>
                            <input type="password" name="password" id="password-field" maxlength="20"
                                   class="form-control " placeholder="گذرواژه">
                            <div class="error_field text-danger">   </div>
                        </div>

                        <div class="checkbox col-xs-10 col-xs-offset-1 mt-10">
                            <input type="checkbox" name="remember" id="remember">
                            <label class="control-label" for="remember"> مرا بخاطر بسپار</label>
                        </div>

                        <div class="col-xs-12 form-group">
                            <button  class="btn bg-b-Jibmib btn-login">ورود <i class="mdi mdi-login"></i></button>
                        </div>
                        <div class="col-xs-12 text-center">
                            <span>
                                درسایت عضویت ندارید؟ <br>
                                در صورتی که ثبت نام نکرده اید <a href="{{route('register.form')}}" class="link-for-register">اینجا</a> کلیک کنید
                            </span>
                            <br>
                            <a href="{{route('forgot.password.form')}}" class="link-for-register"> گذرواژه را فراموش کردید؟</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <br>
@endsection

