@extends('panel.layouts.master')

@section('title')
    {{isset($title)?$title:'تنظیمات'}}
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">

            <div class="col-md-12 box-margin">
                @include('messages.error-validation')

                <div class="card card-body">
                    <h4 class="card-title">تنظیمات {{isset($title)?$title:'تنظیمات'}}</h4>
                    @include('panel.settings.partials.fields')
                </div>

            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>
@endsection




