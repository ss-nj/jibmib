@extends('layouts.master')

@section('style')
    <style>
        body{
            background: url(images/bg1.jpg);
        }
    </style>
@endsection

@section('title')
    اصلاح گذرواژه
@endsection



@section('content')
    <div class="container-fluid">
        <div class="row" dir="rtl">
            <div class="sign-form">
                <div class="form-logo">
                    <a href="{{route('home')}}">
                        <img src="{{asset(trim($siteSettings['site_logo']->value_fa))}}" alt="Jibmib-logo">
                    </a>
                </div>

                <div id="login">
                    <form action="{{route('new.password')}}" method="post">
                        @csrf

                        <div class="col-xs-12 form-group">
                            <label for="password-field"><i class="mdi mdi-key"></i> گذرواژه جدید</label>
                            <input type="password" name="password" id="password-field" maxlength="20"
                                   class="form-control" placeholder="گذرواژه جدید">
                        </div>

                         <div class="col-xs-12 form-group">
                            <label for="password-field"><i class="mdi mdi-key"></i> تکرار گذرواژه جدید</label>
                            <input type="password" name="password_confirmation" id="password-field" maxlength="20"
                                   class="form-control" placeholder="تکرار گذرواژه جدید">
                        </div>

                        <div class="checkbox col-xs-10 col-xs-offset-1 mt-10">
                            <input type="checkbox" name="remember" id="remember">
                            <label class="control-label" for="remember"> مرا بخاطر بسپار</label>
                        </div>

                        <div class="col-xs-12 form-group">
                            <button  class="btn bg-b-Jibmib btn-login">ورود <i class="mdi mdi-login"></i></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection



