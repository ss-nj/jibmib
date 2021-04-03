@extends('panel.layouts.master')

@section('title')
    پشتیبان گیری محصولات
@endsection

@section('content')
    <div class="offcanvas-wrapper">

    <!-- Page Title-->
        <div class="page-title">
            <div class="container">
                <div class="column">
                    <h1>پشتیبان گیری محصولات</h1>

                </div>
            </div>
        </div>
        <!-- Page Content-->
        <div class="card bg-light mt-3">
            <div class="card-header">
                پشتیبان گیری محصولات
            </div>
            <div class="card-body">
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-success">ورودی از اکسل</button>
                    <a class="btn btn-warning" href="{{ route('export') }}">خروجی اکسل</a>
                </form>
            </div>
        </div>
    </div>
@endsection

