@extends('layouts.master')

@section('title')
    ورود به سایت
@endsection



@section('content')
    <div class="container-fluid">
        <div class="row" dir="rtl">
            <div class="sign-form">
                <form action="{{route('forgotten-password.verify.mobile')}}" method="post" id="verify_form">
                    <div class="form-logo">
                        <a href="{{route('home')}}">
                            <img src="{{asset(trim($siteSettings['site_logo']->value_fa))}}" alt="Jibmib-logo">
                        </a>
                    </div>
                    <div class="message-light">
                        <small> برای شماره همراه {{$mobile}} کد تایید ارسال گردید</small>
                    </div>
                    @csrf
                    <div class="col-xs-12 form-group">
                        <label class="control-label">محل ورود کد تایید ارسال برای تلفن همراه</label>
                        <input type="text" maxlength="5" name="code" autofocus class="form-control"
                               placeholder="کد تایید">

                    </div>
                    <div class="col-xs-12 form-group">
                        <a href="javascript:{}" class="btn bg-b-Jibmib btn-login"
                           onclick="document.getElementById('verify_form').submit();">تایید <i class="fa fa-check"></i></a>

                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

