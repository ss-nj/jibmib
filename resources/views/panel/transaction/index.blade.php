@extends('panel.layouts.master')

@section('title')مدیریت تراکنشها@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست تراکنشها</h4>
                        <div class="portlet light row ">
                            <div class="form-group col-md-4">

                                <label for="ajaxId" class="form-control-label">شماره:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxId form-control" id="ajaxId" name="ajaxId">
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxUserName" class="form-control-label">قسمتی از نام با شماره همراه کاربر:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxUserName form-control" id="ajaxUserName" name="ajaxUserName">
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxAmount" class="form-control-label">مقدار تراکنش(کمتر از):</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxAmount form-control" id="ajaxAmount" name="ajaxAmount">
                                </div>
                            </div>


                            <div class="form-group col-md-4">

                                <label for="ajaxApproved" class="form-control-label">وضعیت :</label>
                                <select name="ajaxApproved" id="ajaxApproved" class="form-control ajaxApproved ">
                                    <option value="">انتخاب کنید</option>
                                    <option value="1">موفق</option>
                                    <option value="0">نا موفق</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="ajaxSortBy" class="form-control-label">مرتب سازی بر اساس :</label>
                                <select name="ajaxSortBy" id="ajaxSortBy" class="ajaxSortBy form-control">
                                    <option value="created_at">تاریخ ایجاد</option>
                                    <option value="id">شماره</option>

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

{{--    @include('panel.uploads.uuid')--}}
    @include('panel.shops.approve')

@endsection

@push('css')
    <link href="{{url('vendors/datatables/datatables.bundle.rtl.css')}}" rel="stylesheet">
    <style>
        td.details-control {
            background: url('{{asset('assets/details_open.png')}}') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('{{asset('assets/details_close.png')}}') no-repeat center center;
        }

        table.detail td {
            border: 1px solid #ebedf2;
        }

    </style>
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


        var dataTable = $('#transactions-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('transaction.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxUserName = $('.ajaxUserName').val();
                    var ajaxAmount = $('.ajaxAmount').val();
                    var ajaxApproved = $('#ajaxApproved').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchById = ajaxId;
                    data.searchByUserNmae = ajaxUserName;
                    data.searchByAmount = ajaxAmount;
                    data.searchByStatus = ajaxApproved;
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
                {data: 'id', name: 'id', title: '#', 'className': 'text-center details-control', orderable: false},
                {data: 'name', name: 'name', title: 'نام ', 'className': 'text-center', orderable: false},
                {data: 'amount', name: 'amount', title: 'مقدار', 'className': 'text-center', orderable: false},
                {data: 'status', name: 'status', title: 'وضعیت', 'className': 'text-center', orderable: false},
                {data: 'created_at', name: 'created_at', title: 'زمان ایجاد', 'className': 'text-center', orderable: false},
                {data: 'payment_date', name: 'payment_date', title: 'زمان پرداخت', 'className': 'text-center', orderable: false},
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
        $('.ajaxName ,.ajaxId,.ajaxCode,.ajaxUserName,.ajaxAmount').keyup((event) => {
            dataTable.draw();
        });

        //inputs
        $('#ajaxApproved ,#ajaxSortBy ,#ajaxAscDesc').change((event) => {
            dataTable.draw();
        });

        /* Formatting function for row details */
        function format(d) {
            var base = "{{url('/')}}";
            // `d` is the original data object for the row
            var data = '<h6>لیست خرید</h6>'
                +'<table class="detail" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px">'

                + '<tr>'
                + '<td>نام کوپن</td>'
                + '<td>نام فروشگاه</td>'
                + '<td>تعداد</td>'
                + '<td>قیمت</td>'
                + '</tr>'

            $.each(d.orders, function (key, input) {
                console.log(input)
                data +=
                    '<tr>'
                    + '<td>'+input.takhfif_name+'</td>'
                    + '<td>'+input.takhfif.shop.shop_name+'</td>'
                    + '<td>'+input.takhfif_count+'</td>'
                    + '<td>'+input.takhfif_discount+'</td>'
                    + '</tr>'
            });


            data +=  '</table>';

            return data;
        }

        // Add event listener for opening and closing details
        $('#transactions-table tbody').on('click', 'td.details-control', function () {
            // alert(1)
            var tr = $(this).closest('tr');
            var row = dataTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });


    </script>



@endpush
