@extends('panel.layouts.master')

@section('title')

    {{__('users.users management')}}
@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">
{{--                @include('error-validation')--}}

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">{{__('users.user list')}}</h4>
                        <div class="portlet light row ">
                            <div class="form-group col-md-4">

                                <label for="ajaxName" class="form-control-label">نام:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxName form-control" id="ajaxName" name="ajaxName">
                                </div>
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxFamily" class="form-control-label">نام خانوادگی:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxFamily form-control" id="ajaxFamily" name="ajaxFamily">
                                </div>
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxMobile" class="form-control-label">شماره تماس :</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxMobile form-control" id="ajaxMobile" name="ajaxMobile">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ajaxId" class="form-control-label">شماره کاربری :</label>

                                <div class="form-group">
                                    <input type="number" min="0" class="ajaxId form-control" id="ajaxId" name="ajaxId"  >
                                </div>
                            </div>
{{--                             <div class="form-group col-md-4">--}}
{{--                                <label for="ajaxAff" class="form-control-label">کد معرف :</label>--}}

{{--                                <div class="form-group">--}}
{{--                                    <input type="text"  class="ajaxAff form-control" id="ajaxAff" name="ajaxAff"  >--}}
{{--                                </div>--}}
{{--                            </div>--}}
                             <div class="form-group col-md-4">
                                <label for="ajaxWallet" class="form-control-label">کیف پول :</label>

                                <div class="form-group">
                                    <input type="number" min="0.01" class="ajaxWallet form-control" id="ajaxWallet" name="ajaxWallet" step=".01">
                                </div>
                            </div>

                             <div class="form-group col-md-4">
                                <label for="ajaxAddress" class="form-control-label">آدرس :</label>

                                <div class="form-group">
                                    <input type="text"  class="ajaxAddress form-control" id="ajaxAddress" name="ajaxAddress"  >
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxDisplay" class="form-control-label">وضعیت :</label>
                                <select name="ajaxDisplay" id="ajaxDisplay" class="ajaxDisplay form-control" >
                                    <option value="">انتخاب کنید</option>
                                    <option value="1">نمایش</option>
                                    <option value="0">عدم نمایش</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxRole" class="form-control-label">نقش:</label>
                                <select name="ajaxRole" id="ajaxRole" class="ajaxRole form-control" >
                                    <option value="">انتخاب کنید</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->display_name}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxSortBy" class="form-control-label">مرتب سازی بر اساس :</label>
                                <select name="ajaxSortBy" id="ajaxSortBy" class="ajaxSortBy form-control">
                                    <option value="created_at">تاریخ ایجاد</option>
                                    <option value="mobile">شماره همراه خریدار</option>
                                    <option value="id">شماره کاربری</option>
                                    <option value="full_name">نام</option>
                                    <option value="wallet">کیف پول</option>

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
    @include('panel.users.new-user')

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
        $(document).on('click', '.model-edit', function (e) {

            let Id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "{{url('panel/crm/users/ajax/edit')}}" + '/' + Id,

                // data: {"id": Id},
                success: function (response) {

                    if (response) {
                        $('.model-edit-body').empty();
                        $('.model-edit-body').append(response);
                    } else {


                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
            });
        });
        $(document).on('click', '.model-permission', function (e) {

            let Id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "{{url('panel/crm/users/ajax/permissions')}}" + '/' + Id,

                // data: {"id": Id},
                success: function (response) {

                    if (response) {
                        $('.model-permission-body').empty();
                        $('.model-permission-body').append(response);
                    } else {


                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
            });
        });


        $(document).on('change', '#select-province', function (e) {
            loadCities1($(this));

        });

        function loadCities1(thisObj) {


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
            });
        }


        $(document).on('click', '.remove-image', function (e) {
            e.preventDefault();//Prevent from submitting

            let myProductId = $(this).data('id');
            let img = this;
//get id from data
//pas to controller
//on successful delete remove element

            $.ajax({
                type: "get",
                url: "{{url('panel/crm/remove-image/users')}}" + '/' + myProductId,
                // data: {"id": myProductId},

                success: function (response) {
                    img.closest('.product-image').remove();
                    swal("با موفقیت حذف شد", {
                        dangerMode: false,
                        icon: "success",
                        title: "موفق!",
                        showCloseButton: true,

                    }).then(() => {
                        $('.close-modal').click();
                        $('.buttons-reset').click();
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
            });
        });

        var dataTable = $('#users-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('users.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxRole = $('#ajaxRole').val();
                    var ajaxId = $('.ajaxId').val();
                     var ajaxAddress = $('.ajaxAddress').val();
                    var ajaxFamily = $('.ajaxFamily').val();
                    var ajaxWallet = $('.ajaxWallet').val();
                    var ajaxMobile = $('.ajaxMobile').val();
                    var ajaxDisplay = $('#ajaxDisplay').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchByRole = ajaxRole;
                    data.searchById= ajaxId;
                     data.searchByAddress = ajaxAddress;
                    data.searchByFamily = ajaxFamily;
                    data.searchByWallet = ajaxWallet;
                    data.searchByMobile = ajaxMobile;
                    data.searchByStatus = ajaxDisplay;
                    data.searchSortBy = ajaxSortBy;
                    data.searchByAscDesc = ajaxAscDesc;
                }
            },

            'dom': 'Bfrtip',
            'buttons': [
                {
                    'extend': 'create', 'text': 'ایجاد', 'action': function (e, dt, node, config) {
                        return $('#new-user').modal();
                    }
                },
                {'extend': 'export', 'text': 'خروجی'},
                {'extend': 'print', 'text': 'چاپ'},
                {'extend': 'reset', 'text': 'ریست'},
                {
                    'extend': 'reload', 'text': 'بارگزاری دوباره'
                }],
            columns: [
                {data: 'id', name: 'id', title: '#', 'className': 'text-center', orderable: false},
                {data: 'image', name: 'image', title: 'تصویر', 'className': 'text-center', orderable: false, searchable: false},
                {data: 'full_name', name: 'full_name', title: 'نام', 'className': 'text-center', orderable: false},
                 {data: 'wallet', name: 'wallet', title: 'کیف پول', 'className': 'text-center', orderable: false},
                 {data: 'roles', name: 'roles', title: 'نقش', 'className': 'text-center', orderable: false},
                {data: 'mobile', name: 'mobile', title: 'شماره تماس', 'className': 'text-center', orderable: false},

                {data: 'created_at', name: 'created_at', title: 'تاریخ ایجاد', 'className': 'text-center', orderable: false},
                {data: 'status', name: 'status', title: 'وضعیت', 'className': 'text-center', 'type': 'html', orderable: false},

                {data: 'action', title: 'عملیات', 'className': 'text-center', name: 'action', orderable: false}
            ],
            language: {
                url: '{{url(asset('vendors/datatables/Persian.json'))}}'
            },
            order: [
                [0, 'desc']
            ]
        });


        $('.ajaxFamily').keyup(function () {
            dataTable.draw();
        });

          $('#ajaxRole').change(function () {
            dataTable.draw();
        });

        $('.ajaxAff').keyup(function () {
            dataTable.draw();
        });

         $('.ajaxAddress').keyup(function () {
            dataTable.draw();
        });

        $('.ajaxId').keyup(function () {
            dataTable.draw();
        });

        $('.ajaxName').keyup(function () {
            dataTable.draw();
        });

        $('.ajaxMobile').keyup(function () {
            dataTable.draw();
        });
        $('.ajaxWallet').keyup(function () {
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
    {{--    {{$dataTable->scripts()}}--}}
@endpush
