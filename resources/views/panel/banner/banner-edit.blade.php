@extends('panel.layouts.master')

@section('title')ویرایش بنرها@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">
                <form action="{{route('banner.update', $banner->id)}}" class="ajax_validate" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-2">ویرایش بنر</h4>
                            <div class="portlet light row ">

                                <div class="form-group col-md-6">
                                    <label for="start_time">زمان شروع</label>
                                    <input type="text" autocomplete="off"
                                           class="range-from-example form-control start_date"
                                           name="start_date"
                                           id="start_date"
                                           value="{{verta($banner->start_date)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}"
                                           placeholder="زمان شروع"
                                           title="زمان شروع"
                                    >
                                    <div class="error_field text-danger"> </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="expires_date">زمان پایان</label>
                                    <input type="text" autocomplete="off"
                                           class="range-to-example form-control expires_date"
                                           name="expires_date"
                                           id="expires_date"
                                           value="{{verta($banner->expires_date)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}"
                                           placeholder="زمان پایان"
                                           title="زمان پایان"
                                    >
                                    <div class="error_field text-danger"> </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="category_id" class="form-control-label">دسته بندی:</label>

                                    <div class="form-group">
                                        <select
                                            name="category_id"
                                            id="category_id"
                                            class="form-control select2 category_id"
                                            style="width: 100%;">
                                            <option></option>
                                        @foreach($cached_categories as $cached_category)
                                                <option
                                                    {{$banner->category_id===$cached_category->id?'selected':''}}
                                                    value="{{$cached_category->id}}">{{$cached_category->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="error_field text-danger"> </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <label for="place_id" class="form-control-label">شهر:</label>

                                    <div class="form-group">
                                        <select
                                            name="place_id"
                                            id="place_id"
                                            title="شهر"

                                            class="form-control place_id"
                                            style="width: 100%;">
                                            <option value>انتخاب کنید</option>
                                        @foreach($cached_places as $cached_place)
                                                <option
                                                    {{$banner->place_id===$cached_place->id?'selected':''}}
                                                    value="{{$cached_place->id}}">{{$cached_place->name}}</option>
                                            @endforeach
                                            <div class="error_field text-danger"> </div>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <label for="banner_position" class="form-control-label">موقعیت:</label>

                                    <div class="form-group">

                                        <div class="form-group">
                                            <select
                                                name="banner_position"
                                                id="banner_position"
                                                required
                                                class="form-control banner_position"
                                                style="width: 100%;">
                                                <option></option>
                                                @foreach(\App\Http\Core\Models\Banner\Banner::BANNER_MAP as $key=> $position)
                                                    <option
                                                        {{$banner->banner_position===$key?'selected':''}}
                                                        value="{{$key}}">{{$position['title']}}</option>
                                                @endforeach

                                            </select>
                                            <div class="error_field text-danger"> </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group col-md-4">

                                    <label for="title" class="form-control-label">متن دکمه:</label>

                                    <div class="form-group">
                                        <input type="text" class="form-control title"
                                               title="متن دکمه"
                                               name="title"
                                               id="title"
                                               value="{{$banner->title}}"
                                        >
                                        <div class="error_field text-danger"> </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">

                                    <label for="banners_url" class="form-control-label">لینک دکمه:</label>

                                    <div class="form-group">
                                        <input type="text" class="form-control banners_url"
                                               title="لینک دکمه"
                                               name="banners_url"
                                               id="banners_url"
                                               value="{{$banner->banners_url}}"
                                        >
                                        <div class="error_field text-danger"> </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">

                                    <label for="ajaxName" class="form-control-label">تصویر بنر:</label>

                                    <div class="form-group">

                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled
                                                   required
                                                   placeholder="انتخاب فایل">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                    type="button">انتخاب فایل</button>
                                            </span>

                                        </div>
                                        <input type="file"
                                               name="main_image"
                                               id="main_image"
                                               class="file-upload-default"
                                               style="display: none"
                                               onchange="loadFile(event)"
                                               accept=" .gif, .jpg, .png">
                                        <div class="error_field text-danger">  </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm mb-2 mr-2">
                                            ویرایش بنر
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
                        <h4 class="card-title mb-2">مشاهده ی بنر</h4>
                        <div class="portlet light row ">
                            <img style="width: 100%;" src="{{asset($banner->image->path)}}" id="output"/>
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
