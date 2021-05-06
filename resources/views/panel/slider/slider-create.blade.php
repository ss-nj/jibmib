@extends('panel.layouts.master')

@section('title')ایجاد اسلایدرها@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">
                <form action="{{route('sliders.store')}}" class="ajax_validate" method="post"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-2">ایجاد اسلایدر</h4>
                            <div class="portlet light row ">
                                <div class="form-group col-md-4">

                                    <label for="name" class="form-control-label">عنوان:</label>

                                    <div class="form-group">
                                        <input type="text" title="عنوان" class="name form-control" id="name"
                                               name="name">
                                        <div class="error_field text-danger"> </div>

                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="start_time">زمان شروع</label>
                                    <input type="text" autocomplete="off"
                                           class="range-from-example form-control start_time"
                                           name="start_time"
                                           id="start_time"
                                           placeholder="زمان شروع"
                                           title="زمان شروع"
                                    >
                                    <div class="error_field text-danger"> </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="expire_time">زمان پایان</label>
                                    <input type="text" autocomplete="off"
                                           class="range-to-example form-control expire_time"
                                           name="expire_time"
                                           id="expire_time"
                                           placeholder="زمان پایان"
                                           title="زمان پایان"
                                    >
                                    <div class="error_field text-danger"></div>
                                </div>

                                <div class="col-md-4">
                                    <label for="category_id" class="form-control-label">دسته بندی:</label>

                                    <div class="form-group">
                                        <select name="category_id" id="category_id"
                                                class="form-control select2 category_id"
                                                style="width: 100%;">
                                            @foreach($cached_categories as $cached_category)
                                                <option
                                                    value="{{$cached_category->id}}">{{$cached_category->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="error_field text-danger"></div>
                                    </div>

{{--                                    <div class="form-group">--}}
{{--                                        <label--}}
{{--                                            class="cr mb-0">--}}
{{--                                            <input type="checkbox" name="filter_takhfif_by_category"--}}
{{--                                                   style="display: inline-block"--}}
{{--                                                   value="1"--}}
{{--                                                   checked>--}}
{{--                                            فیلتر تخفیف--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="col-md-4">
                                    <label for="place_id" class="form-control-label">شهر:</label>

                                    <div class="form-group">
                                        <select name="place_id" id="place_id"
                                                title="شهر"

                                                class="form-control mySelect2"
                                                style="width: 100%;">
                                            @foreach($cached_places as $cached_place)
                                                <option value="{{$cached_place->id}}">{{$cached_place->name}}</option>
                                            @endforeach
                                            <div class="error_field text-danger"></div>
                                        </select>
                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <label--}}
{{--                                            class="cr mb-0">--}}
{{--                                            <input type="checkbox" name="filter_takhfif_by_place"--}}
{{--                                                   style="display: inline-block"--}}
{{--                                                   value="1"--}}
{{--                                                   checked>--}}
{{--                                            فیلتر تخفیف--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="col-md-4">
                                    <label for="takhfif_id" class="form-control-label">تخفیف:</label>

                                    <div class="form-group">
                                        <select name="takhfif_id" id="takhfif_id"
                                                title="تخفیف"
                                                class="form-control mySelect2 takhfif_id"
                                                style="width: 100%;">
                                        </select>
                                        <div class="error_field text-danger"> </div>
                                    </div>

                                </div>

                                <div class="form-group col-md-4">

                                    <label for="button_text" class="form-control-label">متن دکمه:</label>

                                    <div class="form-group">
                                        <input type="text" class="button_text form-control" id="button_text"
                                               title="متن دکمه"
                                               name="button_text">
                                        <div class="error_field text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">

                                    <label for="button_link" class="form-control-label">لینک دکمه:</label>

                                    <div class="form-group">
                                        <input type="text" class="button_link form-control" id="button_link"
                                               title="لینک دکمه"
                                               name="button_link">
                                        <div class="error_field text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">

                                    <label for="ajaxName" class="form-control-label">تصویر اسلایدر:</label>

                                    <div class="form-group">

                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled
                                                   placeholder="انتخاب فایل">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                    type="button">انتخاب فایل</button>
                                            </span>

                                        </div>
                                        <input type="file" name="main_image" class="file-upload-default main_image"
                                               style="display: none"
                                               onchange="loadFile(event)"
                                               accept=" .gif, .jpg, .png">
                                        <div class="error_field text-danger"> </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm mb-2 mr-2">
                                            ایجاد اسلایدر
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end col -->

        </div>
        <div class="row">
            <div class="col-xl-12 box-margin">
                {{--                @include('error-validation')--}}

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">مشاهده ی اسلاید</h4>
                        <div class="portlet light row ">
                            <img style="width: 100%" id="output"/>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>
    <hr>
@endsection




@push('internal_js')
    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

    </script>
@endpush
