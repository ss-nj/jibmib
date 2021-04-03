@extends('panel.layouts.master')

@section('title')
    مقادیر
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-md-4 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ایجاد مقادیر </h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{ route('attribute-value.store',$attribute->id) }}" method="post" enctype="multipart/form-data"
                                  class="ajax_validate"
                                  accept-charset="utf-8">
                                {{ csrf_field() }}
                                <input type="hidden" name="attribute_id" value="{{$attribute->id}}">
                                <div class="form-group">
                                    <label for="name">مقدار  </label>
                                    <input type="text" class="form-control value "
                                           name="value"
                                           placeholder="مقدار"
                                           >
                                    <div class="error_field text-danger"></div>

                                </div>
                                <button type="submit"
                                        class="btn btn-primary mr-2 btn-block ">ثبت</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 box-margin">
                {{--                @include('error-validation')--}}

                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title mb-2">لیست مقادیر ویژگی   {{$attribute->title}}</h4>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 20%">مقدار</th>
                                    <th style="width: 32%;">عملیات</th>
                                </tr>
                                </thead>
                                <tbody class="sortable" data-entityname="attribute-value">
                                @foreach($values as $index => $value)
                                    <tr data-itemId="{{{ $value->id}}}">
                                        <td class="sortable-handle"><span
                                                class="glyphicon glyphicon-sort"></span>{{$loop->iteration }}</td>
                                        <td>{{$value->position}}</td>

                                        <td class="form_name">{{$value->value }}</td>

                                        <td>

                                            <form action="{{ route('attribute-value.destroy', $value->id) }}"
                                                  style="display: inline;"
                                                  id="frm-delete-attribute-value{{ $value->id }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <a href="#" class="btn btn-circle btn-icon-only"
                                                   onclick="deleteWithModal('frm-delete-attribute-value', '{{ $value->id }}', event)"><i
                                                        class="fa fa-trash alert-danger"></i></a>
                                            </form>

                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>

                            <div class="dataTables_paginate paging_full_numbers text-center" id="kt_table_1_paginate">
                                {{$values->links()}}

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- end row -->
    </div>
@endsection

@push('js')

    <script>


        /**
         * @param {*} requestData
         */
        var changePosition = function (requestData) {
            $.ajax({
                'url': '{{url('/')}}'+'/sort',
                'type': 'POST',
                'data': requestData,
                'success': function (data) {
                    if (data.success) {
                        console.log('Saved');
                    } else {
                        console.log(data.errors);
                    }
                },
                'error': function () {
                    console.log('مشکلی پیش آمده!');
                }
            });
        };

        $(document).ready(function () {
            var $sortableTable = $('.sortable');
            if ($sortableTable.length > 0) {
                $sortableTable.sortable({
                    handle: '.sortable-handle',
                    axis: 'y',
                    update: function (a, b) {
                        var entityName = $(this).data('entityname');
                        var $sorted = b.item;
                        var $previous = $sorted.prev();
                        var $next = $sorted.next();
                        if ($previous.length > 0) {
                            changePosition({
                                "_token": "{{ csrf_token() }}",
                                parentId: $sorted.data('parentid'),
                                type: 'moveAfter',
                                entityName: entityName,
                                id: $sorted.data('itemid'),
                                positionEntityId: $previous.data('itemid')
                            });
                        } else if ($next.length > 0) {
                            changePosition({
                                "_token": "{{ csrf_token() }}",
                                parentId: $sorted.data('parentid'),
                                type: 'moveBefore',
                                entityName: entityName,
                                id: $sorted.data('itemid'),
                                positionEntityId: $next.data('itemid')
                            });
                        } else {
                            console.log('Something wrong!');
                        }
                    },
                    cursor: "move"
                });
            }
            $('.sortable td').each(function () {
                $(this).css('width', $(this).width() + 'px');
            });

        });


    </script>
@endpush

