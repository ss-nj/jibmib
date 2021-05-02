@extends('shop.layouts.master')

@section('title')ایجاد درخواست بازگشت وجه@endsection

@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1 class="text-dark mb-n2 mb-md-0">لیست درخواست بازگشت وجه</h1>
                </div>

                <div class="col-md-4 order-1 order-md-2 align-self-center mb-1 mb-md-0">
                    <ul class="breadcrumb d-block text-md-right">
                        <li><a href="{{route('shop.dashboard')}}">داشبورد</a></li>
                        <li class="active"><a href="{{route('shop.takhfifs.index')}}">لیست درخواست بازگشت وجه</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <div class="col-md-12 mb-5 mb-lg-0 appear-animation animated fadeInUpShorter appear-animation-visible"
         data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" style="animation-delay: 400ms;">
        <div class="portlet light row ">
            <div class="col-sm-12">
                <h4 ><span class="text-danger">موجودی کیف پول شما  :</span> <span class="text-success">0</span></h4>
            </div>
            <div class="form-group col-md-4">

                <label for="ajaxId" class="form-control-label">شماره:</label>

                <div class="form-group">
                    <input type="text" class="ajaxId form-control" id="ajaxId" name="ajaxId">
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

@include('shop.refund.new-refund')


    <div class="modal fade" id="model-edit">
        <div class="modal-dialog modal-lg model-edit-body">

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
        $(document).on('click', '.model-edit', function (e) {

            let Id = $(this).data("id");
            $.ajax({
                type: "post",
                url: "{{url('shop/refund/ajax/edit')}}" + '/' + Id,

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

    </script>
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        var dataTable = $('#refund-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('shop.refund.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxId = $('.ajaxId').val();
                    var ajaxDisplay = $('#ajaxDisplay').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();

                    // Append to data
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
                {'extend': 'print', 'text': 'چاپ'},
                {'extend': 'reset', 'text': 'ریست'},
                {
                    'extend': 'reload', 'text': 'بارگزاری دوباره'
                }],
            columns: [
                {data: 'id', name: 'id', title: '#', 'className': 'text-center', orderable: false},
                {data: 'by_admin', name: 'by_admin', title: 'خودکار', 'className': 'text-center', orderable: false},
                {data: 'amount', name: 'amount', title: 'مقدار', 'className': 'text-center', orderable: false},
                {data: 'bank_id', name: 'bank_id', title: 'شماره حساب', 'className': 'text-center', orderable: false},
                {data: 'description', name: 'description', title: 'توضیح', 'className': 'text-center', orderable: false},
                {data: 'status', name: 'status', title: 'وضعیت', 'className': 'text-center', orderable: false},

                {data: 'created_at', name: 'created_at', title: 'تاریخ ایجاد', 'className': 'text-center', orderable: false},

                {data: 'action', title: 'عملیات', 'className': 'text-center', name: 'action', printable: false, orderable: false}
            ],
            language: {
                url: '{{url(asset('vendors/datatables/Persian.json'))}}'
            },
            order: [
                [0, 'desc']
            ]
        });


        //select boxes
        $('.ajaxId,.ajaxCode').keyup((event) => {
            dataTable.draw();
        });

        //inputs
        $('#ajaxSortBy ,#ajaxAscDesc').change((event) => {
            dataTable.draw();
        });


    </script>

@endpush

