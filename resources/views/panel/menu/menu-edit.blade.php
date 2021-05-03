@extends('panel.layouts.master')

@section('title')ویرایش منو@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-sm-9 box-margin">
                <form action="{{route('menus.update', $menu->id)}}" class="ajax_validate" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card">
                        <div class="card card-body">
                            <h4 class="card-title">ویرایش منو</h4>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <form action="{{ route('menus.store') }}" class="ajax_validate" method="post" enctype="multipart/form-data"
                                          accept-charset="utf-8">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name">عنوان منو </label>
                                            <input type="text" class="form-control name" name="name" id="name" value="{{$menu->name}}"
                                                   placeholder="عنوان منو " >
                                            <div class="error_field text-danger"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">موقعیت</label>

                                            <select name="menu"
                                                    class="form-control menu "
                                                    style="width: 100%;">
{{--                                                <option >انتخاب کنید</option>--}}
                                                @foreach(\App\Http\Core\Models\Menu::MENU_MAP as $key=> $position)
                                                    <option value="{{$key}}" {{$menu->position ==$key?'selected':''}} >{{$position}}</option>
                                                @endforeach
                                            </select>
                                            <div class="error_field text-danger"> </div>

                                        </div>
                                        <div class="form-group spec-link">
                                            <label for="link">لینک منو</label>
                                            <input type="text"
                                                   class="form-control link"
                                                   name="link"
                                                   value="{{$menu->link}}"
                                                   id="link"
                                                   placeholder="www.site.com/etc" >
                                            <div class="error_field text-danger"> </div>

                                        </div>

                                        <div class="form-group spec-link">
                                            <label for="link"> ایکن منو<a target="_blank" href="https://iconify.design/icon-sets/fa/">مقدار را از اینجا انتخاب کنید</a></label>
                                            <input type="text" class="form-control icon" name="icon" id="icon"
                                                   value="{{$menu->icon}}"   placeholder="ایکن منو " >

                                            <div class="error_field text-danger"> </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="image">تصویر منو</label>
                                            <div class="form-group">

                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled

                                                           placeholder="انتخاب فایل">
                                                    <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"
                                                    type="button">انتخاب فایل</button>
                                            </span>

                                                </div>
                                                <input type="file"
                                                       name="main_image"
                                                       id="main_image"
                                                       class="file-upload-default main_image"
                                                       style="display: none"
                                                       onchange="loadFile(event)"
                                                       accept=" .gif, .jpg, .png">
                                                <div class="error_field text-danger">  </div>
                                            </div>
                                        </div>

                                        <button type="submit"
                                                class="btn btn-primary mr-2 btn-block ">ارسال</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-3">
                <div class="box-margin">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-2">پیش نمایش تصویر</h4>
                            <div class="portlet light row ">
                                <img style="width: 100%;" src="{{asset($menu->image->path!=\App\Http\Core\Models\Image::NO_IMAGE_PATH?$menu->image->path:"")}}" id="output"/>
                            </div>

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
