@extends('shop.layouts.master')

@section('title')مدیریت@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">لیست کوپنها</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.coupon.index')}}">لیست کوپنهای فروش رفته</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
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

                <label for="ajaxUserName" class="form-control-label">نام(بخشی از نام یا موبایل کاربر):</label>

                <div class="form-group">
                    <input type="text" class="ajaxUserName form-control" id="ajaxUserName" name="ajaxUserName">
                </div>
            </div>
            <div class="form-group col-md-4">

                <label for="ajaxApproved" class="form-control-label">وضعیت :</label>
                <select name="ajaxApproved" id="ajaxApproved" class="form-control ajaxApproved ">
                    <option value="">انتخاب کنید</option>
                    <option value="1">فعال</option>
                    <option value="0">استفاده شده</option>

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

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <div class="row">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade hide" id="revoke-takhfif" tabindex="-1" role="dialog"
         aria-labelledby="formModalLabel" style=" padding-right: 15px;" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formModalLabel">باطل کردن تخفیف</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{route('shop.revoke.coupon')}}" method="post" class="mb-4 ajax_validate">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group row align-items-center">
                            <label class="col-sm-12  mb-0"> کد تخفیف (کد تخفیف تنها توسط خریدار ارایه میشود)</label>
                            <div class="col-sm-9">
                                <input type="text" value="" class="form-control code" name="code"
                                       aria-invalid="true">
                                <div class="error_field text-danger"> </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">بستن</button>
                        <button type="submit" class="btn btn-primary">باطل کردن تخفیف</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection

@push('external_css')
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
        div#shop-coupons-table_wrapper {
            width: 100%;
        }
        table#shop-coupons-table {
            width: 100% !important;
        }


    </style>
@endpush

@push('external_js')
    <script src="{{url('vendors/datatables/datatables.bundle.js')}}"></script>
    <script src="{{ asset('vendors/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/Buttons-1.7.0/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('plugins/DataTables/Responsive-2.2.7/js/dataTables.responsive.min.js') }}"></script>
{{--    <script src="{{ asset('plugins/DataTables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>--}}

@endpush

@push('internal_js')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var dataTable = $('#shop-coupons-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('shop.coupon.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxUserName = $('.ajaxUserName').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchByUserName = ajaxUserName;
                    data.searchById = ajaxId;
                    data.searchSortBy = ajaxSortBy;
                    data.searchByAscDesc = ajaxAscDesc;
                }
            },

            'dom': 'Bfrtip',
            'buttons': [

                // {'extend': 'export', 'text': 'خروجی'},
                {'extend': 'print', 'text': 'چاپ'},
                {
                    'extend': 'reload', 'text': 'بارگزاری دوباره'
                }],
            columns: [
                {data: 'id', name: 'id', title: '#', 'className': 'text-center details-control', orderable: false},
                {data: 'name', name: 'name', title: 'نام ', 'className': 'text-center', orderable: false},
                {data: 'takhfif_name', name: 'takhfif_name', title: 'نام تخفیف', 'className': 'text-center', orderable: false},
                {data: 'takhfif_count', name: 'takhfif_count', title: 'تعداد', 'className': 'text-center', orderable: false},

                {data: 'takhfif_discount', name: 'takhfif_discount', title: 'قیمت', 'className': 'text-center', orderable: false},
                {data: 'status', name: 'status', title: 'وضعیت', 'className': 'text-center', orderable: false},
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
        $('.ajaxName ,.ajaxUserName ,.ajaxId,.ajaxCode').keyup((event) => {
            dataTable.draw();
        });

        //inputs
        $('#ajaxSortBy ,#ajaxAscDesc').change((event) => {
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
                + '<td>موجودی</td>'
                + '<td>تعداد</td>'
                + '<td>قیمت</td>'
                + '</tr>'

                data +=
                    '<tr>'
                    + '<td>'+d.takhfif_name+'</td>'
                    + '<td>'+d.takhfif.capacity+'</td>'
                    + '<td>'+d.takhfif_count+'</td>'
                    + '<td>'+d.takhfif_discount+'</td>'
                    + '</tr>'


            data +=  '</table>';

            return data;
        }

        // Add event listener for opening and closing details
        $('#shop-coupons-table tbody').on('click', 'td.details-control', function () {

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



