@extends('panel.layouts.master')

@section('title')
    مدیریت دسته بندی
@endsection

@section('content')

    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-12 box-margin">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست
                            @if(isset($parent_category))
                                زیر دسته های دسته ی  <a href="{{route('category.index')}}">خانه</a>
                                @foreach(explode('-',$parent_category->parents_array) as $parent)
                                    @php($parent_cat=\App\Http\Commerce\Models\Category::find($parent))
                                    @if($parent_cat)
                                        / <a
                                            href="{{route('category.index',['category_id'=>$parent_cat->id])}}">{{$parent_cat->name}}</a>

                                    @endif
                                @endforeach
                                <div class="row">
                                    <a href="{{route('category.index')}}">
                                        <button type="button"
                                                class="btn btn-primary btn-sm mb-2 mr-2">
                                            بازگشت به دسته های اصلی
                                        </button>
                                    </a>
                                </div>
                            @else
                                دسته بندی ها اصلی

                            @endif
                        </h4>

                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

{{--    <div class="modal fade" id="model-attrtibutes">--}}
{{--        <div class="modal-dialog modal-md model-attrtibutes-body">--}}

{{--        </div>--}}
{{--    </div>--}}
     <div class="modal fade" id="model-edit">
        <div class="modal-dialog modal-md model-edit-body">

        </div>
    </div>
    @include('panel.category.new-category')

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

        $(document).on('click', '.model-attrtibutes', function (e) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            let Id = $(this).data("id");
            $('.model-edit-body').empty();

            $.ajax({
                type: "post",
                url: "{{url('panel/commerce/category/ajax/attributes/edit')}}" + '/' + Id,

                data: {_token: CSRF_TOKEN},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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

        $(document).on('click', '.model-edit', function (e) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            let Id = $(this).data("id");
            $('.model-edit-body').empty();

            $.ajax({
                type: "post",
                url: "{{url('panel/commerce/category/ajax/edit')}}" + '/' + Id,

                data: {_token: CSRF_TOKEN},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
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

        var dataTable = $('#category-table').DataTable({
            'pageLength': 15,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',
            stateSave: true,
            'searching': false,
            'ajax': {
                'url': '{!! route('category.index') !!}',
                'data': function (data) {
                    @if(isset($parent_category))
                        data.category_id = {{$parent_category->id}};
                    @endif
                }
            },

            'dom': 'Bfrtip',
            'buttons': [
                {
                    'extend': 'create', 'text': 'ایجاد', 'action': function (e, dt, node, config) {
                        return $("#new-category").modal();
                    }
                },
                {'extend': 'export', 'text': 'خروجی'},
                {'extend': 'print', 'text': 'چاپ'},
                {'extend': 'reset', 'text': 'ریست'},
                {
                    'extend': 'reload', 'text': 'بارگزاری دوباره'
                }],
            columns: [
                {data: 'id', name: 'id', title: '#', 'className': 'text-center', orderable: true},
                {data: 'image', name: 'image', title: 'تصویر', 'className': 'text-center', orderable: false, searchable: false
                },
                {data: 'attributes', name: 'attributes', title: 'ویژگی ها', 'className': 'text-center', orderable: false},
                {data: 'name', name: 'name', title: 'نام', 'className': 'text-center', orderable: false},
                {data: 'subcategory', name: 'subcategory', title: 'زیر دسته', 'className': 'text-center', orderable: false
                },
                {data: 'position', name: 'position', title: 'ترتیب', 'className': 'text-center', orderable: false},
                {data: 'menu', name: 'menu', title: 'منو', 'className': 'text-center', orderable: false},

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

    </script>
@endpush
