@extends('shop.layouts.master')

@section('title')مدارک فروشگاه@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">مدارک فروشگاه</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.licences.index')}}">مدارک فروشگاه</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <form action="{{route('shop.licences.update',$shop->id)}}" method="post" id="licences-form" class="ajax_validate" enctype="multipart/form-data" >
        @csrf
        @method('put')
        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">مدارک مورد نیاز جهت تایید کسب و کار</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">نام کسب و کار</label>
                            <input type="text" value="{{$shop->shop_name}}" class="form-control " disabled
                                   name="shop_name"
                                   aria-invalid="true">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">دسته بندی</label>
                            <select name="category_id" class="form-control" disabled>
                                @foreach($cached_categories as $cached_category)
                                    <option
                                        {{$cached_category->id ==$shop->category_id?'selected':''}}
                                        value="{{$cached_category->id}}">{{$cached_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <h4 class="mb-4">کارت ملی</h4>
            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">


                    <div class="form-row">
                        <div class="form-group col">
                            <label class=" font-weight-bold text-dark text-2">وضعیت تایید مدارک </label>
                            {{--                            <label class=" font-weight-bold text-dark text-2">لورم اسپم </label>--}}
                        </div>
                    </div>
                    <div class="form-row">
                        <label class=" font-weight-bold text-dark text-2">تصویر کارت ملی خود را بارگزاری کنید</label>
                        <label class=" font-weight-bold text-warning text-2">تصاویر باید از وضوح کافی برخوردار باشند و
                            مشخصات آن با اطلاعات ارسالی همخوانی داشته باشد</label>

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
                               name="userid"
                               id="userid"
                               class="file-upload-default userid"
                               style="display: none"
                               onchange="loadFile(event,'userid_output')"
                               accept=" .gif, .jpg, .png">
                        <div class="error_field text-danger"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <p class="text-danger">

                                @if(!$shop->userid )
                                    لطفا در اولین فرصت تصویر کارت ملی خود را بارگزاری کنید
                                @elseif($shop->userid &&$shop->userid->approved==0)
                                    کارت ملی ارسالی شما رد شد به دلیل : <br>{{$shop->userid->reason}}
                                @elseif($shop->userid &&$shop->userid->approved==1)
                                    کارت ملی ارسالی شما تایید شد .
                                @elseif($shop->userid &&$shop->userid->approved==2)
                                    کارت ملی ارسالی شما در دست بررسی است .
                                @endif
                            </p>
                        </div>
                        <div class="form-group col-sm-12" style="height: 400px;overflow: auto">
                            <br>
                            <img style="width:100%;height: auto"
                                 src="{{asset($shop->userid?$shop->userid->src:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                                 id="userid_output"/>

                        </div>
                    </div>

                </div>
            </div>

            <h4 class="mb-4">پروانه ی کسب</h4>
            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">


                    <div class="form-row">
                        <div class="form-group col">
                            <label class=" font-weight-bold text-dark text-2">وضعیت تایید مدارک </label>
                            {{--                            <label class=" font-weight-bold text-dark text-2">لورم اسپم </label>--}}
                        </div>
                    </div>
                    <div class="form-row">
                        <label class=" font-weight-bold text-dark text-2">تصویر پروانه ی کسب خود را بارگزاری
                            کنید</label>
                        <label class=" font-weight-bold text-warning text-2">تصاویر باید از وضوح کافی برخوردار باشند و
                            مشخصات آن با اطلاعات ارسالی همخوانی داشته باشد</label>

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
                               name="licence"
                               id="licence"
                               class="file-upload-default licence"
                               style="display: none"
                               onchange="loadFile(event,'licence_output')"
                               accept=" .gif, .jpg, .png">
                        <div class="error_field text-danger"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <p class="text-danger">
                                @if(!$shop->licence )
                                    لطفا در اولین فرصت تصویر مجوز خود را بارگزاری کنید
                                @elseif($shop->licence &&$shop->licence->approved==0)
                                    مجوز ارسالی شما رد شد به دلیل : <br>{{$shop->licence->reason}}
                                @elseif($shop->licence &&$shop->licence->approved==1)
                                    مجوز ارسالی شما تایید شد .
                                @elseif($shop->licence &&$shop->licence->approved==2)
                                    مجوز ارسالی شما در دست بررسی است .
                                @endif
                            </p>
                        </div>
                        <div class="form-group col-sm-12" style="height: 400px;overflow: auto">
                            <br>
                            <img style="width:100%;height: auto"
                                 src="{{asset($shop->licence?$shop->licence->src:\App\Http\Core\Models\Image::NO_IMAGE_PATH)}}"
                                 id="licence_output"/>

                        </div>
                    </div>

                </div>
            </div>

        </div>


    </form>

    <div class="col-md-6 offset-md-3 my-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible">
        <button type="submit" form="licences-form" class="btn btn-block btn-primary mb-2">ثبت تغییرات</button>
    </div>


@endsection

@push('internal_js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        var loadFile = function (event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

    </script>

@endpush
