@extends('layouts.master')

@section('content')
    <section id="overview" class="section custom-bg-color-1 custom-background-style-1 m-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">تایید شماره همراه</div>

                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    <small> برای شماره همراه {{Auth::user()->mobile}} کد تایید ارسال گردید</small>                            </div>
                            @endif


                            <form class="d-inline" action="{{route('verify.mobile')}}" method="post" id="verify_form">
                                @csrf

                                <div class="col-xs-12 form-group">
                                    <label class="control-label">محل ورد کد تایید ارسال برای تلفن همراه</label>
                                    <input type="text" maxlength="5" name="code" autofocus class="form-control"
                                           placeholder="کد تایید">

                                </div>

                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">تایید</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

