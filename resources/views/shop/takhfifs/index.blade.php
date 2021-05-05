@extends('shop.layouts.master')

@section('title')ایجاد تخفیف@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">لیست تخفیف</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.takhfifs.index')}}">لیست تخفیف</a></li>
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

                <label for="ajaxApproved" class="form-control-label">وضعیت :</label>
                <select name="ajaxApproved" id="ajaxApproved" class="form-control ajaxApproved ">
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

        <div class="card border-radius-0 bg-color-light border-0 box-shadow-1">
            <div class="card-body">
                <div class="row">
                    {!! $dataTable->table() !!}
                </div>
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


        var dataTable = $('#takhfifs-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('shop.takhfifs.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxApproved = $('#ajaxApproved').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchById = ajaxId;
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
                {data: 'image', name: 'title', title: 'تصویر', 'className': 'text-center', orderable: false},

                {data: 'name', name: 'name', title: 'نام ', 'className': 'text-center', orderable: false},
                {data: 'category', name: 'category', title: 'دسته بندی ', 'className': 'text-center', orderable: false},
                {data: 'display_start_time', name: 'display_start_time', title: 'زمان شروع نمایش', 'className': 'text-center', orderable: false
                },
                {data: 'display_end_time', name: 'display_end_time', title: 'زمان اتمام نمایش', 'className': 'text-center', orderable: false
                },
                {data: 'price', name: 'price', title: 'قیمت', 'className': 'text-center', orderable: false},
                {data: 'discount_price', name: 'discount_price', title: 'قیمت با تخفیف', 'className': 'text-center', orderable: false
                },

                {data: 'status', name: 'status', title: 'وضعیت', 'className': 'text-center', orderable: false},
                {data: 'approved', name: 'approved', title: 'تاییدیه', 'className': 'text-center', orderable: false},
                {data: 'created_at', name: 'created_at', title: 'زمان ایجاد', 'className': 'text-center', orderable: false
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


        //select boxes
        $('.ajaxName ,.ajaxId,.ajaxCode').keyup((event) => {
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
            var data = '<table class="detail" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px">'
                + '<tr>'
                + '<td>نام تخفیف :</td>'
                + '<td>' + d.name + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>نام مالک:</td>'
                + '<td>' + d.shop.shop_name + '</td>'
                + '<td>شماره تماس :</td>'
                + '<td>' + d.shop.phone + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>زمان شروع نمایش :</td>'
                + '<td>' + d.display_start_time + '</td>'
                + '<td>زمان پایان نمایش :</td>'
                + '<td>' + d.display_end_time + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>زمان شروع تخفیف :</td>'
                + '<td>' + d.start_time + '</td>'
                + '<td>زمان پایان تخفیف :</td>'
                + '<td>' + d.expire_time + '</td>'
                + '</tr>'


                + '<tr>'
                + '<td>هزینه :</td>'
                + '<td>' + d.price + '</td>'
                + '<td>هزینه همراه با تخفیف :</td>'
                + '<td>' + d.discount_price + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>مهلت استفاده :</td>'
                + '<td>' + d.time_out + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>ظرفیت :</td>'
                + '<td>' + d.capacity + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>توضیح :</td>'
                + '<td>' + d.description + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>تعداد تمایش :</td>'
                + '<td>' + d.view_count + '</td>'
                + '</tr>'


            '</table>';



            return data;
        }

        // Add event listener for opening and closing details
        $('#takhfifs-table tbody').on('click', 'td.details-control', function () {

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

