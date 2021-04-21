@extends('panel.layouts.master')

@section('title')مدیریت فروشگاهها@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست فروشگاهها</h4>
                        <div class="portlet light row ">
                            <div class="form-group col-md-4">

                                <label for="ajaxId" class="form-control-label">شماره:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxId form-control" id="ajaxId" name="ajaxId">
                                </div>
                            </div>
                            <div class="form-group col-md-4">

                                <label for="ajaxTitle" class="form-control-label">نام:</label>

                                <div class="form-group">
                                    <input type="text" class="ajaxTitle form-control" id="ajaxTitle" name="ajaxTitle">
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

                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

    @include('panel.uploads.uuid')
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


        var dataTable = $('#shops-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('shops.index') !!}',
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

                {
                    data: 'shop_name',
                    name: 'shop_name',
                    title: 'نام فروشگاه',
                    'className': 'text-center',
                    orderable: false
                },
                {data: 'address', name: 'address', title: 'آدرس', 'className': 'text-center', orderable: false},
                {data: 'phone', name: 'phone', title: 'شماره تماس', 'className': 'text-center', orderable: false},
                // {data: 'bank_id', name: 'bank_id', title: 'شماره حساب', 'className': 'text-center', orderable: false},
                // {data: 'bank_account_owner_name', name: 'bank_account_owner_name', title: 'نام صاحب حساب', 'className': 'text-center', orderable: false},

                {data: 'approve', name: 'approve', title: 'وضعیت', 'className': 'text-center', orderable: false},
                {data: 'status', name: 'status', title: 'وضعیت', 'className': 'text-center', orderable: false},
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
        $('#ajaxApproved ,#ajaxSortBy ,#ajaxAscDesc').change((event) => {
            dataTable.draw();
        });

        /* Formatting function for row details */
        function format(d) {
            var base = "{{url('/')}}";
            // `d` is the original data object for the row
            var data = '<table class="detail" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px">'
                + '<tr>'
                + '<td>نام فروشگاه :</td>'
                + '<td>' + d.shop_name + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>نام مالک:</td>'
                + '<td>' + d.owner_name + '</td>'
                + '<td>شماره تماس :</td>'
                + '<td>' + d.phone + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>استان :</td>'
                + '<td>' + d.province.name + '</td>'
                + '<td>شهر :</td>'
                + '<td>' + d.city.name + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>ادرس :</td>'
                + '<td>' + d.address + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>لوکیشن :</td>'
                + '<td>' + d.lat + '-' + d.lang + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>توضیح :</td>'
                + '<td>' + d.description + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>شماره حساب :</td>'
                + '<td>' + d.bank_id + '</td>'
                + '<td>شماره شبا :</td>'
                + '<td>' + d.isbn + '</td>'
                + '</tr>'

                + '<tr>'
                + '<td>نام صاحب حساب :</td>'
                + '<td>' + d.bank_account_owner_last_name + '</td>'
                + '<td>شماره ملی :</td>'
                + '<td>' + d.uuid + '</td>'
                + '</tr>'

            '</table>';

            data += '<table class="detail" cellpadding="5" cellspacing="0" style="padding-left:50px">'
                + '<tr>'
                + '<td>تصویر مجوز :</td>';


            if (d.licence) {
                data += '<td><img style="width: 120px" src="' + base + '/' + d.licence.src + '" alt=""></td>'
            }
            data += '<td>وضعیت تایید</td>'
                + '<td>'
            if (!d.licence)
                data += '  بارگزاری نشده'
            else if (d.licence.approved == 0)
                data += '  رد شد به دلیل :' + d.licence.reason;
            else if (d.licence.approved == 1)
                data += 'تایید شده'
            else if (d.licence.approved == 2) {
                data += '<button class="btn btn-success mt-ladda-btn ladda-button approve-Modal-bot" '
                    + ' data-id="'
                    + d.licence.id
                    + '" '
                    + ' data-src="'
                    + d.licence.src
                    + '" '
                    + ' data-reason="'
                    + d.licence.reason
                    + '" >'

                    + 'بررسی'
                    + '</button>'
            }
            data += ' </td>'
                + '</tr>'

                + '</table>'

                + '<table class="detail" cellpadding="5" cellspacing="0" style="padding-left:50px">'
                + '<tr>'
                + '<td>تصویر کارت ملی :</td>'

            if (d.userid) {
                data += '<td><img style="width: 120px" src="' + base + '/' + d.userid.src + '" alt=""></td>'
            }
            data +=
                '<td>وضعیت تایید</td>'

                + '<td>'

            if (!d.userid)
                data += '  بارگزاری نشده'
            else if (d.userid.approved == 0)
                data += '  رد شد به دلیل :' + d.userid.reason;
            else if (d.userid.approved == 1)
                data += 'تایید شده'
            else if (d.userid.approved == 2) {
                data += '<button class="btn btn-success mt-ladda-btn ladda-button approve-Modal-bot" ' +
                    ' data-id="'
                    + d.userid.id
                    + '" '
                    + ' data-src="'
                    + d.userid.src
                    + '" '
                    + ' data-reason="'
                    + d.userid.reason
                    + '"  >'
                    + 'بررسی'
                    + '</button>'
            }
            data += ' </td>'

                + '</tr>'

                + '</table>';

            data += '<table class="detail" cellpadding="5" cellspacing="0"  style="padding-left:50px">'
                + '<tr>'
                + '<td>وضعیت تایید فروشگاه</td>'
                + '<td>'

            if (d.approved == 0)
                data += '  رد شد به دلیل :' + d.disapprove.reason;
            else if (d.approved == 1)
                data += 'تایید شده'
            else if (d.approved == 2) {
                data += '<button class="btn btn-success mt-ladda-btn ladda-button approve-shop-bot" ' +
                    ' data-id="'
                    + d.id
                    + '"  >'
                    + 'بررسی'
                    + '</button>'
            }
            data += ' </td>'

                + '</td>'
                + '</tr>'
                + '</table>'
            return data;
        }

        // Add event listener for opening and closing details
        $('#shops-table tbody').on('click', 'td.details-control', function () {
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

    <script>
        $(document).on('click', '.approve-Modal-bot', function () {
            let Id = $(this).attr('data-id');
            let Src = $(this).attr('data-src');
            let Reason = $(this).attr('data-reason');
            let Form = $('.approve_form');
            let Modal = $('#approve-Modal');
            let Url = "{{url('panel/commerce/shops/approve/')}}" + '/' + Id
            let base = "{{url('/')}}";

            Form.attr('action', Url);
            $('.uploaded_img').attr('src', base + '/' + Src);
            $('.deny_reason_text').valu = Reason;

            Modal.modal('show');
            //set src
            //set form action

        })
    </script>

    <script>
        $(document).on('click', '.approve-shop-bot', function () {
            let Id = $(this).attr('data-id');
            let Form = $('.approve_shop_form');
            let Modal = $('#approve-shop-modal');
            let Url = "{{url('panel/commerce/shops/approve-shop/')}}" + '/' + Id

            Form.attr('action', Url);

            Modal.modal('show');

        })
    </script>
@endpush
