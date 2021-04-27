@extends('panel.layouts.master')

@section('title')مدیریت درخواست بازگشت وجه@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">
                <h4 class="card-title mb-2">خروجی گرفتن از لیست ایمیلها</h4>

                <div class="card">
                    <div class="card-body">
                        <div class="portlet light row ">
                            <div class="card-body">

                                <a class="btn btn-warning" href="{{ route('notice.export') }}">خروجی اکسل</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

@endsection


