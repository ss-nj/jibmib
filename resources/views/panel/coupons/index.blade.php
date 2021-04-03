@extends('panel.layouts.master')

@section('title')مدیریت کوپن ها@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">
                {{--                @include('error-validation')--}}

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست کوپن ها</h4>
                        <div class="portlet light row ">
                            <div class="form-group col-md-4">

                                <label for="ajaxId" class="form-control-label">شماره:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxId form-control" id="ajaxId" name="ajaxId">
                                </div>
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxName" class="form-control-label">نام:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxName form-control" id="ajaxName" name="ajaxName">
                                </div>
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxCode" class="form-control-label">کد :</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxCode form-control" id="ajaxCode" name="ajaxCode">
                                </div>
                            </div>


                            <div class="form-group col-md-4">

                                <label for="ajaxType" class="form-control-label">نوع :</label>
                                <select name="ajaxType" id="ajaxType" class="form-control ajaxType ">
                                    <option value="">انتخاب کنید</option>
                                    <option value="0">درصد</option>
                                    <option value="1">مقدار</option>

                                </select>
                            </div>

                           <div class="form-group col-md-4">

                                <label for="ajaxDisplay" class="form-control-label">وضعیت :</label>
                                <select name="ajaxDisplay" id="ajaxDisplay" class="form-control ajaxDisplay ">
                                    <option value="">انتخاب کنید</option>
                                    <option value="1">نمایش</option>
                                    <option value="0">عدم نمایش</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxSortBy" class="form-control-label">مرتب سازی بر اساس :</label>
                                <select name="ajaxSortBy" id="ajaxSortBy" class="ajaxSortBy form-control">
                                    <option value="created_at">تاریخ ایجاد</option>
                                    <option value="id">شماره</option>
                                    <option value="name">نام</option>
                                    <option value="code">کد</option>

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
                        <div class="row">
                            <a href="{{route('coupons.create')}}">  <button type="button"
                                                                            class="btn btn-primary btn-sm mb-2 mr-2">
                                    ایجاد تخفیف جدید
                                </button></a>
                        </div>
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
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

        $(document).ready(function () {
            loadProvinces();
        });

        $('.select-province').change(function () {

            loadCities($(this));
        });


        function loadProvinces() {

            dropdown = $('.select-province');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');
            $.ajax({
                type: "get",
                url: "{{url('provinces')}}",

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

            });
        }

        function loadCities(thisObj) {


            let valueSelected = thisObj.val();
            if (!valueSelected) return;
            dropdown = $('.select-city');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');

            $.ajax({
                type: "get",
                url: "{{url('cities')}}",

                data: {"province_id": valueSelected},
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
                        dropdown.append('<option selected disabled>بدون مقدار</option>');
                        dropdown.prop('required', false);

                    }


                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {

                // $('#select-collection').trigger('change');
            });
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var dataTable = $('#coupons-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('coupons.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxCode = $('.ajaxCode').val();
                    var ajaxType = $('.ajaxType').val();
                    var ajaxDisplay = $('#ajaxDisplay').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchById = ajaxId;
                    data.searchByType = ajaxType;
                    data.searchByCode = ajaxCode ;
                    data.searchByStatus = ajaxDisplay;
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
                {data: 'name', name: 'name', title: 'نام', 'className': 'text-center', orderable: false},
                {data: 'code', name: 'code', title: 'کد', 'className': 'text-center', orderable: false},
                {data: 'type', name: 'type', title: 'نوع', 'className': 'text-center', orderable: false},
                {data: 'position', name: 'position', title: 'ترتیب', 'className': 'text-center', orderable: false},

                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'تاریخ ایجاد',
                    'className': 'text-center',
                    orderable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'وضعیت',
                    'className': 'text-center',
                    'type': 'html',
                    orderable: false
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


        $('.ajaxCode').keyup(function () {
            dataTable.draw();
        });

        $('.ajaxType').change(function () {
            dataTable.draw();
        });

        $('.ajaxName').keyup(function () {
            dataTable.draw();
        });
        $('.ajaxId').keyup(function () {
            dataTable.draw();
        });


        $('#ajaxDisplay').change(function () {
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
