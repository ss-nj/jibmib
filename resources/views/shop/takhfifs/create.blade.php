@extends('shop.layouts.master')

@section('title')ایجاد تخفیف@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">ایجاد تخفیف</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.takhfifs.index')}}">پروفایل کاربری</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
    <form action="{{route('shop.takhfifs.update',$takhfif->id)}}" method="post" id="takhfif-form" class="ajax_validate">
        @csrf
        @method('put')

        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">اطلاعات تخفیف</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">دسته بندی فروشگاه</label>
                            <select name="" class="form-control" id="select_parent_category" disabled>
                                @foreach($cached_categories as $cached_category)
                                    <option value="{{$cached_category->id}}"
                                        {{$shop->category_id==$cached_category->id?'selected':''}}
                                    >{{$cached_category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">دسته بندی های محصول </label>
                            <select name="categories[]" class="form-control select2 categories" multiple>
                                @foreach($cached_categories as $cached_category)
                                    <option value="{{$cached_category->id}}"
                                    {{in_array($cached_category->id ,$takhfif->categories->pluck('id')->toArray() )?'selected':''}}
                                    >{{$cached_category->name}}</option>
                                @endforeach
                            </select>
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="error_field text-danger"></div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label class=" font-weight-bold text-dark text-2">عنوان</label>
                            <input type="text" value="{{$takhfif->name}}" class="form-control name" name="name" aria-invalid="true">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col">
                            <label class=" font-weight-bold text-dark text-2">توضیحات</label>
                            <textarea maxlength="5000" rows="8" class="form-control description"
                                      name="description">{{$takhfif->description}}</textarea>
                            <div class="error_field text-danger"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-12">
                        <label class=" font-weight-bold text-dark text-2">تگها</label>
                        <label class=" font-weight-bold text-success text-2">برای جستجو و سئوی بهتر تعدادی از کلمات اصلی مرتبط با آگهی را وارد کنید.</label>
                        <select name="tags[]" class="form-control select2Tag" multiple>
                            @foreach(explode(',', $takhfif->tags ) as $tag)
                               @if(!empty($tag)) <option selected>{{$tag}}</option>@endif
                            @endforeach
                        </select>
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

        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">قیمت</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-lg-5">
                            <label class=" font-weight-bold text-dark text-2">قیمت اصلی</label>
                            <input type="number" min="0"  value="{{$takhfif->price}}" class="form-control price price_input" name="price"
                                   aria-invalid="true">
                            <div class="error_field text-danger"></div>
                            <div class="price-persian text-success"></div>
                        </div>
                        <label class=" col-lg-2 "><i class="arrow hrb d-inline-block"></i></label>
                        <div class="form-group col-lg-5">
                            <label class=" font-weight-bold text-dark text-2">قیمت با تخفیف</label>
                            <input type="number" min="0"  value="{{$takhfif->discount_price}}" class="form-control text-left price_input discount_price"
                                   name="discount_price" dir="ltr">
                            <div class="error_field text-danger"></div>
                            <div class="price-persian text-success"></div>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-lg-5">
                            <label class=" font-weight-bold text-dark text-2">میزان کمیسیون تخفیفان</label>
                        </div>
                        <div class="col-lg-2"></div>
                        <div class="form-group col-lg-5">
                            <label class=" font-weight-bold text-dark text-2">درآمد کسب و کار از هر فروش</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">تاریخ نمایش پکیج بر روی سایت</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">تاریخ شروع</label>
                            <input type="text"  value="{{verta($takhfif->display_start_time)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}"  class="range-from-example form-control display_start_time"
                                   name="display_start_time" aria-invalid="true">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">تاریخ پایان</label>
                            <input type="text"  value="{{verta($takhfif->display_end_time)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}"
                                   class="range-to-example form-control text-left display_end_time"
                                   name="display_end_time" dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
             data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
            <h4 class="mb-4">تاریخ اعتبار کوپن ها</h4>

            <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
                <div class="card-body">
                    <label class=" font-weight-bold text-warning text-2">در صورت تکمیل این دو فیلد مهلت استفاده غیر
                        فعال میشود </label>

                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">تاریخ شروع استفاده</label>
                            <input type="text" value="{{verta($takhfif->usage_start_time)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}" class="usage_start_time form-control start_time"
                                   name="start_time" aria-invalid="true">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">تاریخ پایان</label>
                            <input type="text" value="{{verta($takhfif->usage_expire_time)->timezone('Asia/Tehran')->format('Y-m-d-H:i')}}" class="usage_expire_time form-control text-left expire_time"
                                   name="expire_time" dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>

                    </div>


                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">مهلت استفاده(روز)</label>
                            <input type="number" min="0" value="{{$takhfif->time_out}}"  class="form-control time_out" name="time_out"
                                   aria-invalid="true">
                            <div class="error_field text-danger"></div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class=" font-weight-bold text-dark text-2">ظرفیت فروش</label>
                            <input type="number" min="0" value="{{$takhfif->capacity}}" class="form-control text-left capacity"
                                   name="capacity" dir="ltr">
                            <div class="error_field text-danger"></div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </form>

    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
        <h4 class="mb-4">شرایط استفاده</h4>

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <form action="{{route('shop.usage_term.store',$takhfif->id)}}" method="post" class="ajax_validate">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <input type="text" name="value"
                                   maxlength="150" title="مقدار"
                                   class="value form-control text-left edit-submit-input"
                                   dir="ltr">
                            <div class="error_field text-danger"></div>
                            <button type="submit" class="btn btn-primary btn-with-arrow mb-2 edit-submit-bot"
                                    href="#">ثبت<span><i
                                        class="fas fa-chevron-left"></i></span></button>
                            <br>
                            <br>
                        </div>

                    </div>

                </form>
                <div class="row">
                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>متن شرط استفاده</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody id="term-table">

                        @foreach($terms as $term)
                            <tr id="term-tr-{{$term->id}}">
                                <td>#</td>
                                <td>{{$term->value}}</td>

                                <td>
                                    <a class="fa fa-trash text-warning fa-2x py-2 term_remove"
                                       data-id="{{$term->id}}"></a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
        <h4 class="mb-4">ویژگی ها</h4>

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <form action="{{route('shop.parameters.store',$takhfif->id)}}" method="post" class="ajax_validate">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <input type="text" name="value"
                                   maxlength="150" title="ویژگی"
                                   class="value form-control text-left edit-submit-input"
                                   dir="ltr">
                            <div class="error_field text-danger"></div>
                            <button type="submit" class="btn btn-primary btn-with-arrow mb-2 edit-submit-bot"
                                    href="#">ثبت<span><i
                                        class="fas fa-chevron-left"></i></span></button>
                            <br>
                            <br>
                        </div>

                    </div>

                </form>
                <div class="row">
                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>متن ویژگی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody id="parametrs-table">

                        @foreach($parameters as $parameter)
                            <tr id="parameter-tr-{{$parameter->id}}">
                                <td>#</td>
                                <td>{{$parameter->value}}</td>

                                <td>
                                    <a class="fa fa-trash text-warning fa-2x py-2 parameter_remove"
                                       data-id="{{$parameter->id}}"></a>
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
        <button type="submit" form="takhfif-form" class="btn btn-block btn-primary mb-2">ثبت تغییرات</button>
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
            top: -4px;
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

            url: "{{route('shop.takhfif.upload.images',$takhfif->id)}}",
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

                $.getJSON('{{route('shop.takhfif.load.images',$takhfif->id)}}', function (data) { // get the json response

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
                    url: "{{url('shop/takhfifs-destroy-image')}}" + '/' + id,
                    data: {_token: CSRF_TOKEN},
                    success: function (data) {
                        // console.log('success: ' + data.success);
                        let _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // console.log('error: ' + data.success);
                    }
                });

            }
        });

    </script>

    <script>
        function addParameter(Id, value) {

            var parametrsField =
                '<tr id="parameter-tr-' + Id + '">'
                + '<td>#</td>'
                + '<td>' + value + '</td>'
                + '<td>'
                + '<a class="fa fa-trash text-warning fa-2x py-2 parameter_remove"'
                + ' data-id="' + Id + '"></a>'
                + '</td>'
                + '</tr>'
            $('#parametrs-table').append(parametrsField);
        }

        function addTerm(Id, value) {

            var termField =
                '<tr id="term-tr-' + Id + '">'
                + '<td>#</td>'
                + '<td>' + value + '</td>'
                + '<td>'
                + '<a class="fa fa-trash text-warning fa-2x py-2 term_remove"'
                + ' data-id="' + Id + '"></a>'
                + '</td>'
                + '</tr>'
            $('#term-table').append(termField);
        }

    </script>

    <script>
        $(document).on('click', '.parameter_remove', function () {
            let Id = $(this).attr('data-id');
            parameterRemove(Id);
        })

        function parameterRemove(Id) {
            let timeId = Id;

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "post",
                url: "{{url('/').'/shop/parameters/'}}" + timeId,

                data: {"_method": 'delete', "_TOKEN": CSRF_TOKEN},
                success: function (response) {

                    if (response.data.success) {
                        alert(response.data.message);
                        $('#parameter-tr-' + Id).remove();

                    } else {
                        alert(response.data.message);
                    }

                },
                error: function (data) {

                }

            }).done(function (response) {
            });
        }

        $(document).on('click', '.term_remove', function () {
            let Id = $(this).attr('data-id');
            termRemove(Id);
        })

        function termRemove(Id) {
            let timeId = Id;

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "post",
                url: "{{url('/').'/shop/usage-term/'}}" + timeId,

                data: {"_method": 'delete', "_TOKEN": CSRF_TOKEN},
                success: function (response) {

                    if (response.data.success) {
                        alert(response.data.message);
                        $('#term-tr-' + Id).remove();

                    } else {
                        alert(response.data.message);
                    }

                },
                error: function (data) {

                }

            }).done(function (response) {
            });
        }

    </script>

    <script>
        $(document).ready(function () {

            var to1, from1;
            to1 = $(".usage_expire_time").persianDatepicker({
                inline: false,
                // initialValueType: 'gregorian',
                observer: true,
                format: 'YYYY-MM-DD-H:mm',
                initialValue: false,
                onSelect: function (unix) {
                    to1.touched = true;

                    if (from1 && from1.options && from1.options.maxDate != unix) {
                        var cachedValue = from1.getState().selected.unixDate;
                        from1.options = {maxDate: unix};
                        if (from1.touched) {
                            from1.setDate(cachedValue);

                        }
                    }
                }
            });
            from1 = $(".usage_start_time").persianDatepicker({
                inline: false,
                // initialValueType: 'gregorian',
                observer: true,
                format: 'YYYY-MM-DD-H:mm',
                initialValue: false,
                onSelect: function (unix) {

                    from1.touched = true;
                    if (to1 && to1.options && to1.options.minDate != unix) {
                        var cachedValue = to1.getState().selected.unixDate;
                        to1.options = {minDate: unix};
                        if (to1.touched) {
                            to1.setDate(cachedValue);

                        }
                    }
                }
            });

        });
    </script>
    <script>
        $(".select2Tag").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })
    </script>

@endpush
