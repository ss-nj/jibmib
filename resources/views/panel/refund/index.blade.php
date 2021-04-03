@extends('panel.layouts.master')

@section('title')مدیریت درخواست بازگشت وجه@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست درخواست بازگشت وجه</h4>
                        <div class="portlet light row ">
                            <div class="form-group col-md-4">

                                <label for="ajaxId" class="form-control-label">شماره:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxId form-control"  name="ajaxId">
                                </div>
                            </div>
                             <div class="form-group col-md-4">

                                <label for="ajaxName" class="form-control-label">نام فروشگاه:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxName form-control"  name="ajaxName">
                                </div>
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxOwner" class="form-control-label">نام صاحب فروشگاه یا شماره تلفن:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxOwner form-control" name="ajaxOwner">
                                </div>
                            </div>


                            <div class="form-group col-md-4">

                                <label for="ajaxDisplay" class="form-control-label">وضعیت :</label>
                                <select name="ajaxDisplay" id="ajaxDisplay" class="ajaxDisplay form-control">
                                    <option value="">انتخاب کنید</option>
                                    <option value="1">در دست بررسی</option>
                                    <option value="0">تایید شده</option>
                                    <option value="0">پرداخت شده</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxSortBy" class="form-control-label">مرتب سازی بر اساس :</label>
                                <select name="ajaxSortBy" id="ajaxSortBy" class="ajaxSortBy form-control">
                                    <option value="created_at">تاریخ ایجاد</option>
                                    <option value="id">شماره</option>
                                    <option value="name">نام</option>

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

        @include('panel.refund.new-refund')


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

        $(document).ready(function () {
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.model-edit', function (e) {

            let Id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "{{url('panel/crm/refund/ajax/edit')}}" + '/' + Id,

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


        var dataTable = $('#refund-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('refunds.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxDisplay = $('#ajaxDisplay').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchById = ajaxId;
                    data.searchByStatus = ajaxDisplay;
                    data.searchSortBy = ajaxSortBy;
                    data.searchByAscDesc = ajaxAscDesc;
                }
            },

            'dom': 'Bfrtip',
            'buttons': [
                {
                    'extend': 'create', 'text': 'ایجاد', 'action': function (e, dt, node, config) {
                        return $('#new-refund').modal();
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
                {data: 'shop_id', name: 'shop_id', title: 'فروشگاه', 'className': 'text-center', orderable: false},
                {data: 'by_admin', name: 'by_admin', title: 'خودکار', 'className': 'text-center', orderable: false},
                {data: 'amount', name: 'amount', title: 'مقدار', 'className': 'text-center', orderable: false},
                {data: 'bank_id', name: 'bank_id', title: 'شماره حساب', 'className': 'text-center', orderable: false},
                {data: 'description', name: 'description', title: 'توضیح', 'className': 'text-center', orderable: false},
                {data: 'approve_date', name: 'approve_date', title: 'زمان تایید', 'className': 'text-center', orderable: false},
                {data: 'pay_date', name: 'pay_date', title: 'زمان پرداخت', 'className': 'text-center', orderable: false},

                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'تاریخ ایجاد',
                    'className': 'text-center',
                    orderable: false
                },
                // {
                //     data: 'status',
                //     name: 'status',
                //     title: 'وضعیت',
                //     'className': 'text-center',
                //     'type': 'html',
                //     orderable: false
                // },

                {data: 'action', title: 'عملیات', 'className': 'text-center', name: 'action', orderable: false}
            ],
            language: {
                url: '{{url(asset('vendors/datatables/Persian.json'))}}'
            },
            order: [
                [0, 'desc']
            ]
        });


        //select boxes
        $('.ajaxName ,.ajaxId').keyup((event) => {
            dataTable.draw();
        });

        //inputs
        $('#ajaxDisplay ,#ajaxSortBy ,#ajaxAscDesc').change((event) => {
            dataTable.draw();
        });
    </script>
@endpush
