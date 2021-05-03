@extends('shop.layouts.master')

@section('title')ویرایش مشخصات فروشگاه@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">ویرایش مشخصات فروشگاه</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.profiles.index')}}">پروفایل کاربری</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <form action="{{route('shop.profiles.update',$shop->id)}}" method="post" id="profile-form" class="ajax_validate">
        @csrf
        @method('put')
        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">اطلاعات عمومی کسب و کار</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">نام کسب و کار</label>
                            <input type="text" value="{{$shop->shop_name}}" class="form-control " name="shop_name"
                                   aria-invalid="true">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">دسته بندی</label>
                            <select name="category_id" class="form-control" id="">
                                @foreach($cached_categories as $cached_category)
                                    <option
                                        {{$cached_category->id ==$shop->category_id?'selected':''}}
                                        value="{{$cached_category->id}}">{{$cached_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label class=" font-weight-bold text-dark text-2">توضیحات</label>
                            <textarea maxlength="5000" rows="8" class="form-control " name="description">{{$shop->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <label class=" font-weight-bold text-dark text-2">نشان تجاری کسب و کار</label>

                        <div class="input-group col-xs-12">

                            <img style="width: 60px;height: 60px" src="{{asset($shop->logo->path)}}" id="output"/>
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
                               class="file-upload-default main_image"
                               style="display: none"
                               onchange="loadFile(event)"
                               accept=" .gif, .jpg, .png">
                        <div class="error_field text-danger"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="productimages" class="col-form-label"><i
                                    class="mdi mdi-camera mdi-20px light-grey-2"></i> تصاویر </label><br>
                            <small class="col-form-label">تصاویر بدون رفرش شدن صفحه به
                                روز
                                رسانی میشوند . موقع حذف احتیاط کنید</small>
                            <div class="">
                                <div
                                    class="product-image-dropzone "
                                    id="product-image-dropzone" data-dz-message>
                                    @csrf
                                    <div class="fallback">
                                        <input name="file" type="file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-12 mb-5 mt-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">اطلاعات تماس کسب و کار</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">استان</label>
                            <select class="form-control select2 select-province" style="width: 100%"
                                    title="استان را انتخاب کنید"
                                    name="province_id" id="select-province">
                            </select>
                            <div class="error_field text-danger"></div>
                        </div>

                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">شهر</label>
                            <select class="form-control select2 select-city " style="width: 100%"
                                    title="شهر را انتخاب کنید"
                                    name="city_id" id="select-city">
                            </select>
                            <div class="error_field text-danger"></div>
                        </div>

                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">منطقه</label>
                            <select class="form-control  select-place " style="width: 100%"
                                    title="منطقه را انتخاب کنید"
                                    name="place_id" id="select-place">
                            </select>
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class=" font-weight-bold text-dark text-2">آدرس</label>
                            <input type="text" value="{{$shop->address}}"
                                   class="form-control text-left address " name="address" dir="ltr">
                            <div class="error_field text-danger"></div>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">شماره تماس</label>
                            <input type="number" class="form-control text-left" id="new-phone" dir="ltr"
                                   min="0" max="99999999999999" title="شماره تماس">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <br>
                            <button type="button" class="btn btn-outline fa fa-plus btn-primary mt-2"
                                    id="submit-new-phone">
                                افزودن شماره تماس
                            </button>
                        </div>
                    </div>

                    <div id="phones-row">
                        @foreach($phones as $phone)
                            <div class="form-row" id="tr-{{$phone->id}}">
                                <div class="form-group col-lg-6">
                                    <label class=" font-weight-bold text-dark text-2">شماره تماس</label>
                                    <input type="number" value="{{$phone->number}}" disabled min="0"
                                           max="99999999999999" title="شماره تماس"
                                           class="form-control text-left edit-submit-input"
                                           dir="ltr">
                                    <div class="error_field text-danger"></div>
                                    <button type="button" class="btn btn-primary btn-with-arrow mb-2 edit-submit-bot"
                                            data-id="{{$phone->id}}" href="#">ثبت<span><i
                                                class="fas fa-chevron-left"></i></span></button>
                                </div>
                                <div class="form-group col-lg-1">
                                    <br>
                                    <a class="fa fa-trash text-warning fa-2x py-2 phone_remove"
                                       data-id="{{$phone->id}}"></a>
                                    <a class="fa fa-pen text-primary fa-2x p-2 phone-edit"
                                       data-id="{{$phone->id}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <label for="latInput">* انتخاب روی نقشه</label>

                        <label for="latInput">طول </label>
                        <input type="string" name="lat" value="{{$shop->lat}}" class="form-control lat" id="latInput"/>
                        <div class="error_field text-danger"></div>
                        <label for="lngInput">عرض</label>
                        <input id="lngInput" name="lang" value="{{$shop->lang}}" class="form-control lang"/>
                        <div class="error_field text-danger"></div>
                        <div class="row" id="map" style="height : 250px;width: 100%"></div>

                    </div>


                </div>
            </div>

        </div>

        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">اطلاعات حساب</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">
                        <div class="col-12"><span class="text-danger">*</span> نوع کسب و کار
                            <div class="form-check form-check-inline"><label class="form-check-label" for="realUser"
                                                                             id="realUserLabel">حقیقی<input
                                        {{$shop->bank_account_type=='real' ?'checked':''}}
                                        class="form-check-input" type="radio" name="bank_account_type" id="realBusiness"
                                        value="real" checked=""></label></div>
                            <div class="form-check form-check-inline"><label class="form-check-label"
                                                                             for="inlineRadio2">حقوقی<input
                                        {{$shop->bank_account_type=='legal' ?'checked':''}}
                                        class="form-check-input" type="radio" name="bank_account_type" readonly=""
                                        id="legalBusiness" value="legal"></label></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">شبا</label>
                            <input type="text" value="{{$shop->isbn}}" class="form-control isbn" name="isbn"
                                   aria-invalid="true">
                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">کد ملی</label>
                            <input type="number" value="{{$shop->uuid}}" class="form-control text-left uuid" name="uuid"
                                   dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">شماره حساب</label>
                            <input type="number" value="{{$shop->bank_id}}" class="form-control text-left bank_id"
                                   name="bank_id" dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">نام صاحب حساب</label>
                            <input type="text" value="{{$shop->bank_account_owner_name}}"
                                   class="form-control text-left v" name="bank_account_owner_name" dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label class=" font-weight-bold text-dark text-2">نام خانوادگی صاحب حساب</label>
                            <input type="text" value="{{$shop->bank_account_owner_last_name}}"
                                   class="form-control text-left bank_account_owner_last_name" name="bank_account_owner_last_name" dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="productimages" class="col-form-label"><i
                                    class="mdi mdi-camera mdi-20px light-grey-2"></i> مدارک </label><br>
                            <small class="col-form-label">تصاویر بدون رفرش شدن صفحه به
                                روز
                                رسانی میشوند . موقع حذف احتیاط کنید</small>
                            <div class="">
                                <div class="product-image-dropzone "
                                     id="licences-image-dropzone" data-dz-message>
                                    @csrf
                                    <div class="fallback">
                                        <input name="file" type="file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
        <h4 class="mb-4">روزها و ساعات سرویس دهی</h4>

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <form action="{{route('shop.times.store',$shop->id)}}" method="post" class="ajax_validate">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label><input type="checkbox" name="days[]" value="1">شنبه</label>
                                    <label><input type="checkbox" name="days[]" value="2">یکشنبه</label>
                                    <label><input type="checkbox" name="days[]" value="3">دوشنبه</label>
                                    <label><input type="checkbox" name="days[]" value="4">سه شنبه</label>
                                    <label><input type="checkbox" name="days[]" value="5">چهارشنبه</label>
                                    <label><input type="checkbox" name="days[]" value="6">پنجشنبه</label>
                                    <label><input type="checkbox" name="days[]" value="7">جمعه</label>
                                    <label><input type="checkbox" name="days[]" class="days" value="8">روزهای تعطیل رسمی</label>
                                    <div class="error_field text-danger"></div>

                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class=" font-weight-bold text-dark text-2">از ساعت</label>
                                    <div style="direction: ltr" id="timepicker-selectbox1"></div>
                                </div>
                                <div class="col-sm-6">
                                    <label class=" font-weight-bold text-dark text-2">تا ساعت</label>
                                    <div style="direction: ltr" id="timepicker-selectbox2"></div>
                                </div>
                                <div class="error_field text-danger"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-outline btn-rounded btn-tertiary  btn-with-arrow mb-2"
                                href="#">افزودن<span><i class="fas fa-plus"></i></span></button>
                    </div>
                </form>
                <div class="row">
                    <table class="table table-striped " id="time-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>روز هفته</th>
                            <th>ساعت شروع</th>
                            <th>ساعت پایان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php(
$week_day_map=[
   1=>'شنبه',
   2=>'یکشنبه',
   3=>'دوشنبه',
   4=>'سه شنبه',
   5=>'چهارشنبه',
   6=>'پنج شنبه',
   7=>'جمعه',
   8=>'روزهای تعطیل',

]
)
                        @foreach($times as $time)
                            <tr id="time-tr-{{$time->id}}">
                                <td>#</td>
                                <td>
                                    @foreach(unserialize($time->week_day) as $day)
                                        {{$week_day_map[$day]}} -
                                    @endforeach

                                </td>
                                <td>
                                    {{verta($time->start_time)->timezone('Asia/Tehran')->format('H:i')}}
                                </td>
                                <td>
                                    {{verta($time->end_time)->timezone('Asia/Tehran')->format('H:i')}}
                                </td>
                                <td>
                                    <a class="fa fa-trash text-warning fa-2x py-2 time_remove"
                                       data-id="{{$time->id}}"></a>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6 offset-md-3 my-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible">
        <button type="submit" form="profile-form" class="btn btn-block btn-primary mb-2">ثبت تغییرات</button>
    </div>

    <div class="modal hide fade in" id="crop_image" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">تغییر نسبت تصویر</h4>
                    <button type="button" class="close close_cropper" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" id="crop_image_body" style="width: 55vw;height: 50vh">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light close_cropper" data-dismiss="modal" aria-hidden="true">
                        بستن
                    </button>
                    <button type="button" class="btn btn-light" id="cropped_image_submit" data-dismiss="modal">ذخیره
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('external_css')
    <link href="{{asset('plugins/cropper/cropper.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/time-picker/tui-time-picker.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>


    <style>
        .product-image-dropzone .dz-preview .dz-image > img {
            width: 120px;
        }

        .licences-image-dropzone .dz-preview .dz-image > img {
            width: 120px;
        }

        .dz-upload-bt img {
            cursor: pointer !important;
        }

        .edit-submit-bot {
            left: 0;
            z-index: 9999;
            position: absolute;
            top: 29px;
            display: none;
        }

        .dz-upload-bt {
            border: dashed;
            border-radius: 22px;
        }
    </style>
@endpush
@push('internal_js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('plugins/cropper/cropper.min.js') }}"></script>
    <script src="{{ asset('plugins/time-picker/tui-time-picker.min.js') }}"></script>
    {{--    <script src="{{ asset('plugins/leaflet/leaflet.js') }}"></script>--}}
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script>
        var mapCenter = [{{$shop?$shop->lat:'32.62236'}}, {{$shop?$shop->lang:'51.66767'}}];
        var map = L.map('map', {center: mapCenter, zoom: 9});
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 15,
            id: 'sajjad234/cklor31nd251p17t66f9a99i3',
            tileSize: 512,
            language: 'local',
            zoomOffset: -1,
            accessToken: 'pk.eyJ1Ijoic2FqamFkMjM0IiwiYSI6ImNrbG5xcXdlcDBsbnEyd3FyeDR6OXd5N3MifQ.0BRrAzfheujkz0xSsZv_Sg'
        }).addTo(map);

        var marker = L.marker(mapCenter).addTo(map);
        var updateMarker = function (lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Your location :  " + marker.getLatLng().toString())
                .openPopup();
            return false;
        };

        map.on('click', function (e) {
            $('#latInput').val(e.latlng.lat);
            $('#lngInput').val(e.latlng.lng);
            updateMarker(e.latlng.lat, e.latlng.lng);
        });

        var updateMarkerByInputs = function () {
            return updateMarker($('#latInput').val(), $('#lngInput').val());
        }
        $('#latInput').on('input', updateMarkerByInputs);
        $('#lngInput').on('input', updateMarkerByInputs);
    </script>
    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

    </script>

    <script>
        var tpSelectbox = new tui.TimePicker('#timepicker-selectbox1', {
            initialHour: 8,
            initialMinute: 30,
            showMeridiem: false,
            inputType: 'selectbox'
        });

        var tpSelectbox = new tui.TimePicker('#timepicker-selectbox2', {
            initialHour: 23,
            initialMinute: 0,
            showMeridiem: false,
            inputType: 'selectbox'
        });
    </script>

    <script>
        function changeInputMultiple() {
            // $('.dz-hidden-input').removeAttr('multiple')

            var dropZoneInput = document.querySelectorAll('.dz-hidden-input')

            dropZoneInput.forEach(item => {
                item.removeAttribute('multiple');
            })
        }

        $("#product-image-dropzone").dropzone({
            autoDiscover: false,
            uploadMultiple: false,
            dictDefaultMessage: "تصاویر را بر روی این کادر رها کنید",
            // The text used before any files are dropped.
            dictFallbackMessage: 'مرورگر شما قادر به پشتیبانی از این سایت نمی باشد',
            // The text that replaces the default message text it the browser is not supported.
            // dictFallbackText'',
            // The text that will be added before the fallback form. If you provide a fallback element yourself, or if this option is null this will be ignored.
            dictFileTooBig: "حداکثر حجم فایل اپلودی 10 mb می باشد",
            {{--           // If the filesize is too big. {{filesize}} and {{maxFilesize}} will be replaced with the respective configuration values.--}}
            dictInvalidFileType: 'تنها فرمتهای jpg,png قابل استفاده می باشند',
            // If the file doesn't match the file type.
            // dictResponseError:'',
            {{--// If the server response was invalid. {{statusCode}} will be replaced with the servers status code.--}}
            dictCancelUpload: 'کنسل',
            // If addRemoveLinks is true, the text to be used for the cancel upload link.
            dictUploadCanceled: 'کنسل شده',
            // The text that is displayed if an upload was manually canceled
            dictCancelUploadConfirmation: "ایا از متوقف کردن اپلود اطمینان دارید؟",
            // If addRemoveLinks is true, the text to be used for confirmation when cancelling upload.
            dictRemoveFile: "",
            // If addRemoveLinks is true, the text to be used to remove a file.
            dictRemoveFileConfirmation: 'ایا از حذف فایل اطمینان دارید ؟',
            // If this is not null, then the user will be prompted before removing a file.
            dictMaxFilesExceeded: "حداکثر تعداد فایل آپلودی 5 میباشد",
            {{--//Displayed if maxFiles is st and exceeded. The string {{maxFiles}} will be replaced by the configuration value.--}}

            url: "{{route('shop.upload.images',$shop->id)}}",
            paramName: "main_image", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            maxFiles: 5,
            parallelUploads: 5,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            // clickable: '.dz-upload-bt',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            transformFile: function (file, done) {
                // Create Dropzone reference for use in confirm button click handler
                let myDropZone = this;
                let modal = document.getElementById('crop_image');
                modal.classList.add("show");
                modal.style.display = 'block';
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        // myDropZone.removeAllFiles()
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                    }
                }
                let editor = document.getElementById('crop_image_body');
                editor.innerHTML = '';
                document.getElementsByClassName('close_cropper')[0].onclick = function () {
                    modal.style.display = "none";
                    editor.innerHTML = '';
                    // myDropZone.removeAllFiles()
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                }


                // Create confirm button at the top left of the viewport
                let buttonConfirm = document.getElementById('cropped_image_submit');

                buttonConfirm.addEventListener('click', function () {
                    // Get the canvas with image data form Cropper.js
                    let canvas = cropper.getCroppedCanvas({
                        width: 600,
                        height: 400
                    });
                    // Turn the canvas into a Blob (file object without a name)
                    canvas.toBlob(function (blob) {
                        // Create a new Dropzone file thumbnail
                        myDropZone.createThumbnail(
                            blob,
                            myDropZone.options.thumbnailWidth,
                            myDropZone.options.thumbnailHeight,
                            myDropZone.options.thumbnailMethod,
                            false,
                            function (dataURL) {

                                // Update the Dropzone file thumbnail
                                myDropZone.emit('thumbnail', file, dataURL);
                                // Return the file to Dropzone
                                done(blob);
                            });
                    });
                    // Remove the editor form the view
                    editor.innerHTML = '';
                    modal.style.display = "none";

                });
                // Create an image node for Cropper.js
                let image = new Image();
                image.src = URL.createObjectURL(file);
                editor.appendChild(image);

                // Create Cropper.js
                let cropper = new Cropper(image, {aspectRatio: 1.5});


            },
            init: function () {

                changeInputMultiple();

                var thisDropzone = this;


                this.on("dictDefaultMessage", function (file) {
                    alert("تصاویر را بر روی این کادر رها کنید");
                    this.removeFile(file);
                });

                this.on("dictFallbackMessage", function (file) {
                    alert("مرورگر شما قادر به پشتیبانی از این سایت نمی باشد");
                    this.removeFile(file);
                });

                this.on("dictFileTooBig", function (file) {
                    alert("حداکثر حجم فایل اپلودی 10 mb می باشد");
                    this.removeFile(file);
                });

                this.on("dictInvalidFileType", function (file) {
                    alert("تنها فرمتهای jpg,png قابل استفاده می باشند");
                    this.removeFile(file);
                });

                this.on("dictCancelUpload", function (file) {
                    alert("کنسل");
                    this.removeFile(file);
                });

                this.on("dictUploadCanceled", function (file) {
                    alert("کنسل شده");
                    this.removeFile(file);
                });

                this.on("dictCancelUploadConfirmation", function (file) {
                    alert("ایا از متوقف کردن اپلود اطمینان دارید؟");
                    this.removeFile(file);
                });

                this.on("dictRemoveFile", function (file) {
                    alert("حذف");
                    this.removeFile(file);
                });

                this.on("dictRemoveFileConfirmation", function (file) {
                    alert("ایا از حذف فایل اطمینان دارید ؟");
                    this.removeFile(file);
                });

                this.on("error", function (file, msg, xhr) {
                    alert(msg);
                });

                this.on("maxfilesexceeded", function (file) {
                    alert("حداکثر تعداد فایل آپلودی 5 می باشد");
                    this.removeFile(file);
                });

                this.on("dictMaxFilesExceeded", function (file) {
                    alert("حداکثر تعداد فایل آپلودی 5 می باشد");
                    this.removeFile(file);
                });
                //set upload botomn

                var uploadBottom = {name: 'آپلود', id: 999999};
                thisDropzone.options.addedfile.call(thisDropzone, uploadBottom);
                thisDropzone.options.thumbnail.call(thisDropzone, uploadBottom, "{{url('/')}}/no_image.jpg");
                uploadBottom.previewElement.classList.add('dz-upload-bt');
                uploadBottom.previewElement.addEventListener('click', function () {
                    thisDropzone.hiddenFileInput.click();

                });
                $(uploadBottom.previewTemplate).find('.dz-remove,.dz-progress,.dz-details').remove();

                $.getJSON('{{route('shop.load.images',$shop->id)}}', function (data) { // get the json response

                    $.each(data, function (key, value) { //loop through it

                        var mockFile = {name: value.title, size: 1234, id: value.id};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "{{url('/')}}/" + value.thumbnail);
                        mockFile.previewElement.classList.add('dz-success');
                        mockFile.previewElement.classList.add('dz-complete');
                        $(mockFile.previewTemplate).find('.dz-remove').attr('id', value.id);
                        $(mockFile.previewTemplate).find('.dz-remove').addClass('fa fa-trash text-danger');
                        // let remove_handel = document.getElementsByClassName('dz-remove');
                        // remove_handel.classList.add('fa fa-trash');
                        // console.log(value.id)
                    });

                });
            },
            success: function (file, response) {

                // console.log(response);
                $(file.previewTemplate).find('.dz-remove').attr('id', response);
                $(file.previewTemplate).find('.dz-remove').addClass('fa fa-trash text-danger');

                file.previewElement.classList.add("dz-success");
                changeInputMultiple();

            },
            error: function (file, message, xhr) {
                changeInputMultiple();

                // sendMessage('اخطار', 'خطایی در موقع اپلود پیش آمده!');
                $(file.previewElement).remove();
            },
            removedfile: function (file) {
                changeInputMultiple();

                let id = $(file.previewTemplate).find('.dz-remove').attr('id');
                // console.log(id);
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "{{url('shop/destroy-image')}}" + '/' + id,
                    data: {_token: CSRF_TOKEN},
                    success: function (data) {
                        // console.log('success: ' + data.success);
                        let _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // console.log('error: ' + data.success);
                        alert(XMLHttpRequest.responseJSON[0]);

                    }
                });

            }
        });


        $("#licences-image-dropzone").dropzone({
            autoDiscover: false,
            uploadMultiple: false,
            dictDefaultMessage: "تصاویر را بر روی این کادر رها کنید",
            // The text used before any files are dropped.
            dictFallbackMessage: 'مرورگر شما قادر به پشتیبانی از این سایت نمی باشد',
            // The text that replaces the default message text it the browser is not supported.
            // dictFallbackText'',
            // The text that will be added before the fallback form. If you provide a fallback element yourself, or if this option is null this will be ignored.
            dictFileTooBig: "حداکثر حجم فایل اپلودی 10 mb می باشد",
            {{--           // If the filesize is too big. {{filesize}} and {{maxFilesize}} will be replaced with the respective configuration values.--}}
            dictInvalidFileType: 'تنها فرمتهای jpg,png قابل استفاده می باشند',
            // If the file doesn't match the file type.
            // dictResponseError:'',
            {{--// If the server response was invalid. {{statusCode}} will be replaced with the servers status code.--}}
            dictCancelUpload: 'کنسل',
            // If addRemoveLinks is true, the text to be used for the cancel upload link.
            dictUploadCanceled: 'کنسل شده',
            // The text that is displayed if an upload was manually canceled
            dictCancelUploadConfirmation: "ایا از متوقف کردن اپلود اطمینان دارید؟",
            // If addRemoveLinks is true, the text to be used for confirmation when cancelling upload.
            dictRemoveFile: "",
            // If addRemoveLinks is true, the text to be used to remove a file.
            dictRemoveFileConfirmation: 'ایا از حذف فایل اطمینان دارید ؟',
            // If this is not null, then the user will be prompted before removing a file.
            dictMaxFilesExceeded: "حداکثر تعداد فایل آپلودی 5 میباشد",
            {{--//Displayed if maxFiles is st and exceeded. The string {{maxFiles}} will be replaced by the configuration value.--}}

            url: "{{route('shop.upload.licences',$shop->id)}}",
            paramName: "main_image", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            maxFiles: 5,
            parallelUploads: 5,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            // clickable: '.dz-upload-bt',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            transformFile: function (file, done) {
                // Create Dropzone reference for use in confirm button click handler
                let myDropZone = this;
                let modal = document.getElementById('crop_image');
                modal.classList.add("show");
                modal.style.display = 'block';
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                        // myDropZone.removeAllFiles()
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                    }
                }
                let editor = document.getElementById('crop_image_body');
                editor.innerHTML = '';
                document.getElementsByClassName('close_cropper')[0].onclick = function () {
                    modal.style.display = "none";
                    editor.innerHTML = '';
                    // myDropZone.removeAllFiles()
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

                }


                // Create confirm button at the top left of the viewport
                let buttonConfirm = document.getElementById('cropped_image_submit');

                buttonConfirm.addEventListener('click', function () {
                    // Get the canvas with image data form Cropper.js
                    let canvas = cropper.getCroppedCanvas({
                        width: 600,
                        height: 400
                    });
                    // Turn the canvas into a Blob (file object without a name)
                    canvas.toBlob(function (blob) {
                        // Create a new Dropzone file thumbnail
                        myDropZone.createThumbnail(
                            blob,
                            myDropZone.options.thumbnailWidth,
                            myDropZone.options.thumbnailHeight,
                            myDropZone.options.thumbnailMethod,
                            false,
                            function (dataURL) {

                                // Update the Dropzone file thumbnail
                                myDropZone.emit('thumbnail', file, dataURL);
                                // Return the file to Dropzone
                                done(blob);
                            });
                    });
                    // Remove the editor form the view
                    editor.innerHTML = '';
                    modal.style.display = "none";

                });
                // Create an image node for Cropper.js
                let image = new Image();
                image.src = URL.createObjectURL(file);
                editor.appendChild(image);

                // Create Cropper.js
                let cropper = new Cropper(image, {aspectRatio: 1.5});


            },
            init: function () {

                changeInputMultiple();

                var thisDropzone = this;


                this.on("dictDefaultMessage", function (file) {
                    alert("تصاویر را بر روی این کادر رها کنید");
                    this.removeFile(file);
                });

                this.on("dictFallbackMessage", function (file) {
                    alert("مرورگر شما قادر به پشتیبانی از این سایت نمی باشد");
                    this.removeFile(file);
                });

                this.on("dictFileTooBig", function (file) {
                    alert("حداکثر حجم فایل اپلودی 10 mb می باشد");
                    this.removeFile(file);
                });

                this.on("dictInvalidFileType", function (file) {
                    alert("تنها فرمتهای jpg,png قابل استفاده می باشند");
                    this.removeFile(file);
                });

                this.on("dictCancelUpload", function (file) {
                    alert("کنسل");
                    this.removeFile(file);
                });

                this.on("dictUploadCanceled", function (file) {
                    alert("کنسل شده");
                    this.removeFile(file);
                });

                this.on("dictCancelUploadConfirmation", function (file) {
                    alert("ایا از متوقف کردن اپلود اطمینان دارید؟");
                    this.removeFile(file);
                });

                this.on("dictRemoveFile", function (file) {
                    alert("حذف");
                    this.removeFile(file);
                });

                this.on("dictRemoveFileConfirmation", function (file) {
                    alert("ایا از حذف فایل اطمینان دارید ؟");
                    this.removeFile(file);
                });

                this.on("error", function (file, msg, xhr) {
                    alert(msg);
                });

                this.on("maxfilesexceeded", function (file) {
                    alert("حداکثر تعداد فایل آپلودی 5 می باشد");
                    this.removeFile(file);
                });

                this.on("dictMaxFilesExceeded", function (file) {
                    alert("حداکثر تعداد فایل آپلودی 5 می باشد");
                    this.removeFile(file);
                });
                //set upload botomn

                var uploadBottom = {name: 'آپلود', id: 999999};
                thisDropzone.options.addedfile.call(thisDropzone, uploadBottom);
                thisDropzone.options.thumbnail.call(thisDropzone, uploadBottom, "{{url('/')}}/no_image.jpg");
                uploadBottom.previewElement.classList.add('dz-upload-bt');
                uploadBottom.previewElement.addEventListener('click', function () {
                    thisDropzone.hiddenFileInput.click();

                });
                $(uploadBottom.previewTemplate).find('.dz-remove,.dz-progress,.dz-details').remove();

                $.getJSON('{{route('shop.load.licences',$shop->id)}}', function (data) { // get the json response

                    $.each(data, function (key, value) { //loop through it

                        var mockFile = {name: value.title, size: 1234, id: value.id};
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "{{url('/')}}/" + value.thumbnail);
                        mockFile.previewElement.classList.add('dz-success');
                        mockFile.previewElement.classList.add('dz-complete');
                        $(mockFile.previewTemplate).find('.dz-remove').attr('id', value.id);
                        $(mockFile.previewTemplate).find('.dz-remove').addClass('fa fa-trash text-danger');
                        // let remove_handel = document.getElementsByClassName('dz-remove');
                        // remove_handel.classList.add('fa fa-trash');
                        // console.log(value.id)
                    });

                });
            },
            success: function (file, response) {

                // console.log(response);
                $(file.previewTemplate).find('.dz-remove').attr('id', response);
                $(file.previewTemplate).find('.dz-remove').addClass('fa fa-trash text-danger');

                file.previewElement.classList.add("dz-success");
                changeInputMultiple();

            },
            error: function (file, message, xhr) {
                changeInputMultiple();

                // sendMessage('اخطار', 'خطایی در موقع اپلود پیش آمده!');
                $(file.previewElement).remove();
            },
            removedfile: function (file) {
                changeInputMultiple();

                let id = $(file.previewTemplate).find('.dz-remove').attr('id');
                // console.log(id);
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: "{{url('shop/destroy-licences')}}" + '/' + id,
                    data: {_token: CSRF_TOKEN},
                    success: function (data) {
                        // console.log('success: ' + data.success);
                        let _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                       alert(XMLHttpRequest.responseJSON[0]);

                    }
                });

            }
        });

        // });

    </script>

    <script>
        //
        $(document).ready(function () {
            // loadPhones();
        });

        // $(document).on('click', '.edit-submit-input', function () {
        //     let Id = $(this).attr('data-id');
        //     alert(Id);
        // })
        $(document).on('click', '.edit-submit-bot', function () {
            let Id = $(this).attr('data-id');

            editPhone(Id);

        })
        $(document).on('click', '.phone-edit', function () {
            let Id = $(this).attr('data-id');

            $('#tr-' + Id).find('.edit-submit-bot').show();
            $('#tr-' + Id).find('.edit-submit-input').prop('disabled', false);
        })

        $(document).on('click', '.phone_remove', function () {
            let Id = $(this).attr('data-id');
            removePhone(Id);
        })

        $(document).on('click', '.time_remove', function () {
            let Id = $(this).attr('data-id');
            timeRemove(Id);
        })

        $(document).on('click', '#submit-new-phone', (event) => {
            addPhone(this);
        })

        function addPhone() {

            let phoneInput = $('#new-phone');

            let valueSelected = phoneInput.val();
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "post",
                url: "{{route('shop.phones.store',$shop->id)}}",

                data: {"number": valueSelected, "_TOKEN": CSRF_TOKEN},
                success: function (response) {
                    console.log(response.data)
                    console.log(response.data.message)
                    console.log(response.data.success)
                    if (response.data.success) {

                        var phoneField =
                            '<div class="form-row" id="tr-' + response.data.phone_id + '">'
                            + ' <div class="form-group col-lg-6">'
                            + ' <label class=" font-weight-bold text-dark text-2">شماره تماس</label>'
                            + ' <input type="number" value="' + response.data.phone_number
                            + '" disabled   min="0" max="99999999999999" title="شماره تماس"'
                            + ' class="form-control text-left edit-submit-input"'
                            + ' dir="ltr">'
                            + ' <div class="error_field text-danger"></div>'
                            + ' <button type="button" class="btn btn-primary btn-with-arrow mb-2 edit-submit-bot"'
                            + ' data-id="' + response.data.phone_id + '" href="#">ثبت<span><i'
                            + ' class="fas fa-chevron-left"></i></span></button>'
                            + ' </div>'
                            + ' <div class="form-group col-lg-1">'
                            + ' <br>'
                            + ' <a class="fa fa-trash text-warning fa-2x py-2 phone_remove"'
                            + ' data-id="' + response.data.phone_id + '"></a>'
                            + ' <a class="fa fa-pen text-primary fa-2x p-2 phone-edit"'
                            + ' data-id="' + response.data.phone_id + '"></a>'
                            + ' </div>'
                            + ' </div>';
                        $('#phones-row').append(phoneField);
                        alert(response.data.message);
                        phoneInput.removeClass('is-invalid');
                        phoneInput.val('');
                        phoneInput.next(".error_field").text('');

                    } else {
                        alert(response.data.message);
                    }

                },
                error: function (data) {

                    phoneInput.addClass('is-invalid');
                    phoneInput.next(".error_field").text(data.responseJSON.errors['number'][0]);
                }

            }).done(function (response) {
            });
        }

        function editPhone(Id) {

            let phoneid = Id;
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            let phoneInput = $('#tr-' + Id);
            let number = phoneInput.find('.edit-submit-input').val();

            $.ajax({
                type: "post",
                url: "{{url('/')}}" + '/shop/phones/' + phoneid,

                data: {"_TOKEN": CSRF_TOKEN, '_method': 'put', 'number': number},
                success: function (response) {

                    if (response.data.success) {
                        phoneInput.find('.edit-submit-bot').hide();
                        phoneInput.find('.edit-submit-input').prop('disabled', true);
                        phoneInput.find('.edit-submit-input').removeClass('is-invalid');
                        phoneInput.find('.edit-submit-input').next(".error_field").text('');

                        alert(response.data.message);
                    } else {
                        alert(response.data.message);
                    }
                },
                error: function (data) {

                    phoneInput.find('.edit-submit-input').addClass('is-invalid');
                    phoneInput.find('.edit-submit-input').next(".error_field").text(data.responseJSON.errors['number'][0]);
                }

            }).done(function (response) {
            });
        }

        function removePhone(Id) {
            let phoneInput = Id;

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "post",
                url: "{{url('/').'/shop/phones/'}}" + phoneInput,

                data: {"_method": 'delete', "_TOKEN": CSRF_TOKEN},
                success: function (response) {

                    if (response.data.success) {
                        alert(response.data.message);
                        $('#tr-' + Id).remove();

                    } else {
                        alert(response.data.message);
                    }

                },
                error: function (data) {

                }

            }).done(function (response) {
            });
        }


        function addTime(Id, day, start_time, end_time) {

            var phoneField =
                '<tr id="time-tr-' + Id + '">'
                + '<td>#</td>'
                + '<td>'
                + day
                + '</td>'
                + ' <td>'
                + start_time
                + ' </td>'
                + ' <td>'
                + end_time
                + ' </td>'
                + ' <td>'
                + ' <a class="fa fa-trash text-warning fa-2x py-2 time_remove"'
                + ' data-id="' + Id + '"></a>'
                + '</td>'
                + '</tr>'
            $('#time-table').append(phoneField);
        }

        function timeRemove(Id) {
            let timeId = Id;

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "post",
                url: "{{url('/').'/shop/open-Times/'}}" + timeId,

                data: {"_method": 'delete', "_TOKEN": CSRF_TOKEN},
                success: function (response) {

                    if (response.data.success) {
                        alert(response.data.message);
                        $('#time-tr-' + Id).remove();

                    } else {
                        alert(response.data.message);
                    }

                },
                error: function (data) {
console.log(response)
                }

            }).done(function (response) {
            });
        }

    </script>

    <script>
        $(document).ready(function () {
            loadProvinces();
        })

        function loadProvinces() {

            dropdown = $('#select-province');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');
            $.ajax({
                type: "get",
                url: "{{url('provinces')}}",
                // data: {"city-price": valueSelected},

                success: function (response) {

                    if (response.data && response.data.length > 0) {

                        dropdown.prop('required', true);

                        dropdown.empty();
                        dropdown.append('<option  value=""  disabled>استان مورد نظر را انتخاب کنید</option>');

                        dropdown.prop('selectedIndex', 0);
                        for (let i = 0; i < response.data.length; i++) {
                            dropdown.append($('<option>')
                                .attr('value', response.data[i].id)
                                .text(response.data[i].name));
                        }

                    } else {
                        dropdown.empty();
                        dropdown.append('<option selected disabled>بدون مقدار</option>');
                        dropdown.prop('required', false);

                    }


                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
                $('#select-province option').each(function () {
                    if (this.value == {{$shop->province_id??'9999999999999999' }}) {
                        this.selected = true;
                        $('#select-province').trigger('change');
                        return false; // stop searching after we find the first match
                    }
                });
            });
        }

        $('#select-province').change(function () {
            loadCities($(this));

        });

        function loadCities(thisObj) {


            dropdown = $('#select-city');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');
            let valueSelected = thisObj.val();
            $.ajax({
                type: "get",
                url: "{{url('cities')}}",

                data: {"province_id": valueSelected},
                success: function (response) {

                    if (response.data.length > 0) {
                        dropdown.prop('required', true);

                        dropdown.empty();
                        dropdown.append('<option  value="" selected="true" disabled>انتخاب کنید</option>');

                        dropdown.prop('selectedIndex', 0);
                        for (var i = 0; i < response.data.length; i++) {
                            dropdown.append($('<option></option>')
                                .attr('value', response.data[i].id)
                                .text(response.data[i].name));
                        }

                    } else {
                        dropdown.empty();
                        dropdown.append('<option selected="true" disabled>بدون مقدار</option>');
                        dropdown.prop('required', false);

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
                $('#select-city option').each(function () {
                    if (this.value == {{$shop->city_id??'9999999999999999' }}) {
                        this.selected = true;
                        $('#select-city').trigger('change');
                        return false; // stop searching after we find the first match
                    }
                });
            });

        }

        $('#select-city').change(function () {
            loadPlaces($(this));
            // alert(1);
        });

        function loadPlaces(thisObj) {

            dropdown = $('#select-place');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');
            let valueSelected = thisObj.val();
            $.ajax({
                type: "get",
                url: "{{url('places')}}",

                data: {"city_id": valueSelected},
                success: function (response) {

                    if (response.data.length > 0) {
                        dropdown.prop('required', true);

                        dropdown.empty();
                        dropdown.append('<option  value="" selected disabled>انتخاب کنید</option>');

                        dropdown.prop('selectedIndex', 0);
                        for (var i = 0; i < response.data.length; i++) {
                            dropdown.append($('<option></option>')
                                .attr('value', response.data[i].id)
                                .text(response.data[i].name));
                        }

                    } else {
                        dropdown.empty();
                        dropdown.append('<option selected="true" disabled>بدون مقدار</option>');
                        dropdown.prop('required', false);
                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
                $('#select-place option').each(function () {
                    if (this.value == {{$shop->place_id??'9999999999999999' }}) {
                        this.selected = true;
                        $('#select-place').trigger('change');
                        return false; // stop searching after we find the first match
                    }
                });
            });
        }
    </script>
@endpush
