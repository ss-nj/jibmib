@extends('panel.layouts.master')

@section('title')
    {{__('roles.roles')}}
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-4 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ایجاد سمت </h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{ route('roles.store') }}" method="post" class="ajax_validate"
                                  accept-charset="utf-8">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">عنوان(بهتر است از حروف انگلیسی و بدون فاصله استفاده شود) </label>
                                    <input type="text" class="form-control name" name="name"
                                           title="عنوان(بهتر است از حروف انگلیسی و بدون فاصله استفاده شود)"
                                            placeholder="{{__('roles.role name')}} " >
                                    <span class="error_field alert-danger" role="alert"> </span>

                                </div>
                                <div class="form-group">
                                    <label for="display_name">{{__('roles.display name')}} </label>
                                    <input type="text" class="form-control display_name" name="display_name"
                                           title="{{__('roles.display name')}}"
                                            placeholder="{{__('roles.display name')}} "
                                           >
                                    <span class="error_field alert-danger" role="alert"> </span>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('roles.description')}} </label>
                                    <textarea name="description"  cols="30" rows="5"
                                              title="{{__('roles.description')}}"
                                              class="form-control description">
                                    </textarea>

                                    <span class="error_field alert-danger" role="alert"> </span>
                                </div>

                                <button type="submit"
                                        class="btn btn-primary mr-2 btn-block ">{{__('roles.submit')}} </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 box-margin">
                {{--                @include('error-validation')--}}

                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title mb-2">{{__('roles.list of roles')}} </h4>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عنوان </th>
                                    <th>{{__('roles.display name')}} </th>
                                    <th>{{__('roles.description')}} </th>
                                    <th style="width: 120px;">{{__('roles.actions')}} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $index => $role)
                                    <tr>
                                        <td>{{ ++$index }}</td>

                                        <td>{{ $role->name }}</td>

                                        <td>{{ $role->display_name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit( $role->description ,30)}}</td>
                                        <td>
                                            <a  href='' data-toggle='modal' data-target='#model-edit' class='model-edit btn btn-circle btn-icon-only'
                                                data-id="{{ $role->id }}"><i
                                                    class="fa fa-pencil fa-pen"></i></a>
                                            <a href="" data-toggle="modal" class="btn-circle  btn-icon-only"
                                               data-target="#role-permissions-{{ $role->id }}"><i
                                                    class="fa fa-list-alt"></i></a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" class="ajax_validate"
                                                  style="display: inline;" id="frm-delete-role{{ $role->id }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <a href="#" class="btn-circle  btn-icon-only"
                                                   onclick="deleteWithModal('frm-delete-role', '{{ $role->id }}', event)"><i
                                                        class="fa fa-trash alert-danger "></i></a>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="role-permissions-{{ $role->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('roles.permissions.sync', $role->id) }}"
                                                  method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                {{ method_field('put') }}
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{__('roles.edit')}} <span
                                                                class="text-danger">{{ $role->name }}</span></h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @foreach($permissions as $permission)
                                                                @if($loop->index%4===0)
                                                                    <?php $pieces = explode(' ', $permission->display_name);
                                                                    $last_word = array_pop($pieces); ?>
                                                                    <div class="col-12">
                                                                        <hr>
                                                                        <h5> {{$last_word}}:</h5>

                                                                    </div>
                                                                @endif
                                                                <div class="checkbox d-inline mb-2 col-3">
                                                                    <label
                                                                        class="cr mb-0">
                                                                        <input type="checkbox" name="permissions[]"
                                                                               style="display: inline-block"
                                                                               value="{{$permission->id}}"
                                                                            {{ in_array($permission->id ,$role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                                        <?php
                                                                        $words = explode(" ", $permission->display_name);
                                                                        array_splice($words, -1);

                                                                        ?>
                                                                        {{implode( " ", $words )}}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-rounded btn-success">
                                                            ویرایش
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-rounded btn-danger close-modal"
                                                                data-dismiss="modal">انصراف
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
                url: "{{url('panel/crm/role/ajax/edit')}}" + '/' + Id,

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
@endpush


