@extends('panel.layouts.master')

@section('title')مدیریت بنرها@endsection


@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست بنرها</h4>
                        <div class="portlet light row ">

                            <div class="form-group col-md-6">
                                <label for="start_time">زمان شروع</label>
                                <input type="text"
                                       class="range-from-example form-control start_time "
                                       name="start_time"
                                       id="start_time"
                                       placeholder="زمان شروع"
                                       required>


                            </div>

                            <div class="form-group col-md-6">
                                <label for="end_time">زمان پایان</label>
                                <input type="text"
                                       class="range-to-example form-control end_time"
                                       name="end_time"
                                       id="end_time"
                                       placeholder="زمان پایان"
                                       required>

                            </div>

                            <div class="col-md-4">
                                <label for="ajaxCategory" class="form-control-label">دسته بندی:</label>

                                <div class="form-group">
                                    <select name="ajaxCategory"
                                            required
                                            class="form-control select2  ajaxCategory"
                                            style="width: 100%;">
                                        <option></option>
                                        @foreach($cached_categories as $cached_category)
                                            <option value="{{$cached_category->id}}">{{$cached_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <label for="ajaxPlace" class="form-control-label">شهر:</label>

                                <div class="form-group">
                                    <select name="ajaxPlace"
                                            required
                                            class="form-control select2 ajaxPlace"
                                            style="width: 100%;">
                                        <option></option>
                                        @foreach($cached_places as $cached_place)
                                            <option value="{{$cached_place->id}}">{{$cached_place->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <label for="ajaxPosition" class="form-control-label">موقعیت:</label>

                                <div class="form-group">
                                    <select name="ajaxPosition"
                                            required
                                            class="form-control ajaxPosition"
                                            style="width: 100%;">
                                        <option selected value=""> انتخاب کنید</option>
                                        @foreach(\App\Http\Core\Models\Banner\Banner::BANNER_MAP as $key=> $position)
                                            <option value="{{$key}}">{{$position['title']}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>


                            <div class="form-group col-md-4">

                                <label for="ajaxSortBy" class="form-control-label">مرتب سازی بر اساس :</label>
                                <select name="ajaxSortBy" id="ajaxSortBy" class="ajaxSortBy form-control">
                                    <option value="created_at">تاریخ ایجاد</option>
                                    <option value="start_date">تاریخ شروع</option>
                                    <option value="expires_date">تاریخ پایان</option>
                                    <option value="id">شماره بنر</option>
                                    <option value="title">نام</option>

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
                            <a href="{{route('banner.create')}}">
                                <button type="button"
                                        class="btn btn-primary btn-sm mb-2 mr-2">
                                    ایجاد بنر
                                </button>
                            </a>
                        </div>
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

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

        var dataTable = $('#banners-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('banner.index') !!}',
                'data': function (data) {
                    // Read values
                    var ajaxName = $('.ajaxName').val();
                    var ajaxUrl = $('.ajaxUrl').val();
                    var ajaxId = $('.ajaxId').val();
                    var ajaxDisplay = $('.ajaxDisplay').val();
                    var ajaxCategory = $('.ajaxCategory').val();
                    var ajaxPlace = $('.ajaxPlace').val();
                    var ajaxPosition = $('.ajaxPosition').val();
                    var ajaxSortBy = $('#ajaxSortBy').val();
                    var ajaxAscDesc = $('#ajaxAscDesc').val();
                    var start_time = $('#start_time').val();
                    var end_time = $('#end_time').val();


                    // Append to data
                    data.searchByName = ajaxName;
                    data.searchByUrl = ajaxUrl;
                    data.searchByStartTime = start_time;
                    data.searchByEndTime = end_time;
                    data.searchByCategory = ajaxCategory;
                    data.searchByPlace = ajaxPlace;
                    data.searchByPosition = ajaxPosition;
                    data.searchById = ajaxId;
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
                {'extend': 'reload', 'text': 'بارگزاری دوباره'}],
            columns: [
                {data: 'id', name: 'id', title: '#', 'className': 'text-center', orderable: false},
                {
                    data: 'image',
                    name: 'image',
                    title: 'تصویر',
                    'className': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {data: 'title', name: 'title', title: 'عنوان', 'className': 'text-center', orderable: false},
                {data: 'place_id', name: 'place_id', title: 'شهر', 'className': 'text-center', orderable: false},
                {
                    data: 'category_id',
                    name: 'category_id',
                    title: 'دسته بندی',
                    'className': 'text-center',
                    orderable: false
                },
                {
                    data: 'banner_position',
                    name: 'banner_position',
                    title: 'موقعیت',
                    'className': 'text-center',
                    orderable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'زمان ایجاد',
                    'className': 'text-center',
                    orderable: false
                },
                {
                    data: 'start_date',
                    name: 'start_date',
                    title: 'زمان شروع',
                    'className': 'text-center',
                    orderable: false
                },
                {
                    data: 'expires_date',
                    name: 'expires_date',
                    title: 'زمان پایان',
                    'className': 'text-center',
                    orderable: false
                },

                // {data: 'created_at', name: 'created_at', title: 'تاریخ ایجاد', 'className': 'text-center', orderable: false},
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

        $(document).on('click', '.table-days  span', (event) => {
            dataTable.draw();

        })

        //select boxes
        $('.ajaxUrl ,.ajaxId').keyup((event) => {
            dataTable.draw();
        });

        //inputs
        $('.ajaxCategory ,.ajaxPosition, #ajaxDisplay, #ajaxSortBy ,#ajaxAscDesc, .ajaxPlace,#start_time,#end_time').change((event) => {
            dataTable.draw();
        });


    </script>
@endpush
