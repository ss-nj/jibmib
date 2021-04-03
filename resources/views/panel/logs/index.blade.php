@extends('panel.layouts.master')

@section('title')

    مدیریت آمار
@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست لاگها</h4>
                        <div class="portlet light row ">

                            <div class="form-group col-sm-6">
                                <label for="view_start_time">زمان شروع</label>
                                <input type="text" autocomplete="off"
                                       class="range-from-example form-control @error('view_start_time') is-invalid @enderror"
                                       name="view_start_time" id="view_start_time"
                                       value="{{ old('view_start_time') }}"
                                       placeholder="زمان شروع"
                                       required>
                                <input type="hidden" class="observer-from-alt" name="view_start_time"
                                       value="{{ old('view_start_time')??''}}">

                                @error('view_start_time')
                                <span class="alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="view_end_time">زمان پایان</label>
                                <input type="text" autocomplete="off"
                                       class="range-to-example form-control @error('view_end_time') is-invalid @enderror"
                                       name="view_end_time" id="view_end_time"
                                       value="{{ old('view_end_time') }}" placeholder="زمان پایان"
                                       required>
                                <input type="hidden" class="observer-to-alt" name="view_end_time"
                                       value="{{ old('view_end_time')??''}}">

                                @error('view_end_time')
                                <span class="alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxMobile" class="form-control-label">قسمتی از نام یا شماره تماس
                                    کاربر:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxMobile form-control" id="ajaxMobile"
                                           name="ajaxMobile">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ajaxId" class="form-control-label">شماره کاربری :</label>

                                <div class="form-group">
                                    <input type="number" min="0" class="ajaxId form-control" id="ajaxId" name="ajaxId">
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxEvent" class="form-control-label">نوع تغییر :</label>
                                <select name="ajaxEvent" id="ajaxEvent" class="ajaxEvent form-control">
                                    <option value="">انتخاب کنید</option>
                                    <option value="created">ایجاد</option>
                                    <option value="deleted">حذف</option>
                                    <option value="updated">ویرایش</option>
                                    <option value="Logged_In">ورود</option>
                                    <option value="Logged_Out">خروج</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxType" class="form-control-label">انتخاب جدول :</label>
                                <select name="ajaxType" id="ajaxType" class="ajaxType form-control">
                                    <option value="">انتخاب کنید</option>
                                    <option value="user">کاربر</option>
                                    <option value="city_price">شهر</option>
                                    <option value="setting">تنظیمات</option>
                                    <option value="menu">منو</option>

                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ajaxModelId" class="form-control-label">شناسه جدول :</label>

                                <div class="form-group">
                                    <input type="number" min="0" class="ajaxModelId form-control" id="ajaxModelId" name="ajaxModelId">
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxSortBy" class="form-control-label">مرتب سازی بر اساس :</label>
                                <select name="ajaxSortBy" id="ajaxSortBy" class="ajaxSortBy form-control">
                                    <option value="created_at">تاریخ ایجاد</option>
                                    {{--                                    <option value="mobile">شماره همراه خریدار</option>--}}
                                    <option value="id">شماره کاربری</option>
                                    {{--                                    <option value="full_name">نام</option>--}}
                                    {{--                                    <option value="wallet">کیف پول</option>--}}

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxAscDesc" class="form-control-label">صعودی -نزولی :</label>
                                <select name="ajaxAscDesc" id="ajaxAscDesc" class="ajaxAscDesc form-control">
                                    <option value="DESC">نزولی</option>
                                    <option value="ASC">صعودی</option>

                                </select>
                            </div>

                            <hr>
                        </div>
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

    {{--    @include('panel.bill.new-bill')--}}


    <div class="modal fade" id="model-edit">
        <div class="modal-dialog modal-lg model-edit-body">

        </div>
    </div>
@endsection

@push('css')
    <link href="{{url('vendors/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{url('vendors/datatables/datatables.bundle.js')}}"></script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>

@endpush


@push('scripts')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var dataTable = $('#logs-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('log.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxEvent = $('#ajaxEvent').val();
                    var ajaxType = $('#ajaxType').val();
                    var view_start_time = $('#view_start_time').val();
                    var view_end_time = $('#view_end_time').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxModelId = $('.ajaxModelId').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchByModelEvent = ajaxEvent;
                    data.searchByModelType = ajaxType;
                    data.searchByStartTime = view_start_time;
                    data.searchByEndTime = view_end_time;
                    data.searchByUserId = ajaxId;
                    data.searchByModelId = ajaxModelId;
                    data.searchSortBy = ajaxSortBy;
                    data.searchByAscDesc = ajaxAscDesc;
                }
            },

            'dom': 'Bfrtip',
            'buttons': [

                {'extend': 'export', 'text': 'خروجی'},
                {'extend': 'print', 'text': 'چاپ'},
                {'extend': 'reset', 'text': 'ریست'},
                {
                    'extend': 'reload', 'text': 'بارگزاری دوباره'
                }],
            columns: [
                {data: 'id', name: 'id', title: '#', 'className': 'text-center', orderable: false},
                {data: 'event', name: 'event', title: 'نوع تغییر', 'className': 'text-center', orderable: false},
                {data: 'full_name', name: 'full_name', title: 'نام', 'className': 'text-center', orderable: false},
                {data: 'mobile', name: 'mobile', title: 'موبایل', 'className': 'text-center', orderable: false},
                {data: 'old_values', name: 'old_values', title: 'مقادیر قبلی', 'className': 'text-center', orderable: false},
                {data: 'new_values',name: 'new_values', title: 'مقادیر جدید', 'className': 'text-center', orderable: false},
                {data: 'type', name: 'type', title: 'جدول', 'className': 'text-center', orderable: false},
                {data: 'auditable_id', auditable_id: 'type', title: 'شناسه جدول', 'className': 'text-center', orderable: false},
                {data: 'created_at', name: 'created_at', title: 'تاریخ ثبت', 'className': 'text-center', orderable: false
                },

                {data: 'action', title: 'عملیات', 'className': 'text-center', name: 'action', orderable: false}
            ],
            language: {
                url: '{{url(asset('vendors/datatables/Persian.json'))}}'
            },
            order: [
                [0, 'desc']
            ]
        });

        $('#view_start_time').on('input change keyup past propertychange',function(){
            console.log($('#view_start_time').val())
            dataTable.draw();
        });
        $('#view_end_time').on('input change keyup past propertychange',function(){
            dataTable.draw();
        });
        $('.ajaxId').keyup(function () {
            dataTable.draw();
        });
 $('.ajaxModelId').keyup(function () {
            dataTable.draw();
        });

        $('.ajaxName').keyup(function () {
            dataTable.draw();
        });

        $('#ajaxType').change(function () {
            dataTable.draw();
        });

        $('#ajaxEvent').change(function () {
            dataTable.draw();
        });

        $('#ajaxSortBy').change(function () {
            dataTable.draw();
        });
        $('#ajaxAscDesc').change(function () {
            dataTable.draw();
        });
    </script>
@endpush
