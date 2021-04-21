@extends('panel.layouts.master')

@section('title')
    مدیریت منوها
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-md-4 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ایجاد منوی جدید</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{ route('menus.store') }}" class="ajax_validate" method="post" enctype="multipart/form-data"
                                  accept-charset="utf-8">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">عنوان منو </label>
                                    <input type="text" class="form-control name" name="name" id="name"
                                           placeholder="عنوان منو " >
                                    <div class="error_field text-danger"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">موقعیت</label>

                                    <select name="menu"
                                            class="form-control menu "
                                            style="width: 100%;">
                                        <option value="" >انتخاب کنید</option>
                                        @foreach(\App\Http\Core\Models\Menu::MENU_MAP as $key=>$position)
                                            <option  value="{{$key}}"  >{{$position}}</option>
                                        @endforeach
                                    </select>
                                    <div class="error_field text-danger"> </div>

                                </div>

                                <div class="form-group spec-link">
                                    <label for="link">لینک منو</label>
                                    <input type="text"
                                           class="form-control link"
                                           name="link"
                                           id="link"
                                           placeholder="www.site.com/etc" >
                                    <div class="error_field text-danger"> </div>

                                </div>
                                <div class="form-group spec-link">
                                    <label for="link"> ایکن منو<a target="_blank" href="https://iconify.design/icon-sets/fa/">مقدار را از اینجا انتخاب کنید</a></label>
                                    <input type="text" class="form-control icon" name="icon" id="icon"
                                           placeholder="ایکن منو " >

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
                                        <div class="error_field text-danger ">  </div>
                                    </div>
                                </div>
                                <div class="box-margin">

                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-2">پیش نمایش تصویر</h4>
                                            <div class="portlet light row ">
                                                <img style="width: 100%" id="output"/>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="btn btn-primary mr-2 btn-block ">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 box-margin">

                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست منوها</h4>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>لینک</th>
                                    <th>وضعیت</th>
                                    <th>موقعیت</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody class="sortable" data-entityname="menu">
                                @foreach($menus as $menu)
                                    <tr data-itemId="{{{ $menu->id   }}}">
                                        <td class="sortable-handle"><span
                                                class="glyphicon glyphicon-sort"></span>{{$loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset($menu->image->path) }}"
                                                 style="width: 70px ; height: auto"
                                                 class="preview-image form_main_image">
                                        </td>
                                        <td class="id-column">{{{ $menu->name }}}</td>
                                        <td class="id-column">{{{ $menu->link }}}</td>


                                        <td>
                                            <a href="{{route('menus.edit',$menu->id)}}"  class="btn btn-circle btn-icon-only"><i
                                                    class="fa fa-pen "></i></a>

                                            <form action="{{ route('menus.destroy', $menu->id) }}" class="ajax_validate"
                                                  style="display: inline;"
                                                  id="frm-delete-model{{ $menu->id }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <a href="#" class="btn btn-circle btn-icon-only"
                                                   onclick="deleteWithModal('frm-delete-model', '{{ $menu->id }}', event)"><i
                                                        class="fa fa-trash alert-danger"></i></a>
                                            </form>

                                        </td>
                                        <td class="id-column">{{\App\Http\Core\Models\Menu::MENU_MAP[$menu->menu]}}</td>

                                        <td class="text-center">

                                            <a href="{{route('menu.toggle.active',$menu->id)}}"
                                               class="active-btn btn-circle btn-icon-only "
                                               style="display: inline-grid">
                                                <i class=" alert-{{!$menu->active?'danger fa fa-window-close':'success fa fa-check'}} btn-circle active-btn-icon"></i>

                                                <span
                                                    class="badge badge-{{ $menu->active ? 'success' : 'danger' }} active-btn-badge">
                                                {{ $menu->active ? 'فعال' : 'غیرفعال' }}</span>
                                            </a>

                                        </td>
                                    </tr>


                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

@endsection

@push('css')
{{--    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />--}}
{{--    <link href="{{ asset('plugins/fontawesome-iconpicker-master/icon-picker.min.css') }}" rel="stylesheet">--}}

@endpush

@push('internal_js')


@endpush

@push('external_js')
{{--    <script src="{{ asset('plugins/fontawesome-iconpicker-master/icon-picker.min.js') }}"></script>--}}

    <script>

        $('.icon-picker').qlIconPicker({
            'save': 'class'
        });
        /**
         * @param {*} requestData
         */
        var changePosition = function (requestData) {
            $.ajax({
                'url': '{{url('/')}}'+'/sort',
                'type': 'POST',
                'data': requestData,
                'success': function (data) {
                    if (data.success) {
                        console.log('Saved');
                    } else {
                        console.log(data.errors);
                    }
                },
                'error': function () {
                    console.log('مشکلی پیش آمده!');
                }
            });
        };

        $(document).ready(function () {
            var $sortableTable = $('.sortable');
            if ($sortableTable.length > 0) {
                $sortableTable.sortable({
                    handle: '.sortable-handle',
                    axis: 'y',
                    update: function (a, b) {
                        var entityName = $(this).data('entityname');
                        var $sorted = b.item;
                        var $previous = $sorted.prev();
                        var $next = $sorted.next();
                        if ($previous.length > 0) {
                            changePosition({
                                "_token": "{{ csrf_token() }}",
                                parentId: $sorted.data('parentid'),
                                type: 'moveAfter',
                                entityName: entityName,
                                id: $sorted.data('itemid'),
                                positionEntityId: $previous.data('itemid')
                            });
                        } else if ($next.length > 0) {
                            changePosition({
                                "_token": "{{ csrf_token() }}",
                                parentId: $sorted.data('parentid'),
                                type: 'moveBefore',
                                entityName: entityName,
                                id: $sorted.data('itemid'),
                                positionEntityId: $next.data('itemid')
                            });
                        } else {
                            console.log('Something wrong!');
                        }
                    },
                    cursor: "move"
                });
            }
            $('.sortable td').each(function () {
                $(this).css('width', $(this).width() + 'px');
            });

        });


        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

    </script>
@endpush

