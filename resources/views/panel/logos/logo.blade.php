@extends('panel.layouts.master')

@section('title')مدیریت لوگو@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست لوگوها</h4>
                        <div class="portlet light row ">


                                <div class="col-sm-12">
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
{{--                                                <input name="file" type="file"/>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                        </div>

                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

    <div class="modal hide fade in" id="crop_image" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">تغییر نسبت تصویر</h4>
                    <button type="button" class="close close_cropper" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body" dir="ltr" id="crop_image_body" style="width: 55vw;height: 50vh">
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

    <style>
        /*.product-image-dropzone .dz-preview .dz-image > img {*/
        /*    width: 120px;*/
        /*}*/


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

            url: "{{route('logo.upload.images')}}",
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
                        height: 600
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
                let cropper = new Cropper(image, {aspectRatio: 1});


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

                $.getJSON('{{route('logo.load.images')}}', function (data) { // get the json response

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
                    url: "{{url('panel/commerce/logo-destroy-image')}}" + '/' + id,
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



        // });

    </script>


@endpush
