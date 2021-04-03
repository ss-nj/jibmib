@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">تایید شماره همراه</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                <small> برای شماره همراه {{Auth::user()->mobile}} کد تایید ارسال گردید</small>
                            </div>
                        @endif


                        <form class="d-inline" action="{{ route('user.confirm') }}" method="post" id="verify_form">
                            @csrf

                            <div class="col-xs-12 form-group">
                                <h3 class="header-form-Jibmib">درخواست بازیابی گذرواژه</h3>
                                <p>لطفا شماره موبایل خود را وارد نمایید</p>
                                <div class="form-group">
                                    <input type="text" name="mobile" value="{{old('mobile')}}"
                                           maxlength="11" minlength="10"
                                           pattern="^09[0-9]{9}$"
                                           title="{{ old('mobile')?'':'شماره موبایل را به صورت صحیح وارد کنید.' }}"
                                           class="input-ui pr-2 form-control" placeholder="شماره موبایل خود را وارد نمایید"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                </div>

                            </div>

                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">بازیابی</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

