@extends('panel.layouts.master')

@section('title')
    حق دسترسی
@endsection


@section('content')
    <div class="container-fluid">
        <!-- Form row -->
        <div class="row">
            <div class="col-xl-4 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">ایجاد حق دسترسی</h4>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form action="{{ route('permissions.store') }}" method="post" enctype="multipart/form-data"
                                  accept-charset="utf-8">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">نام</label>
                                    <input type="text" class="form-control" id="name" name="name" min="5" max="197"
                                           value="{{ old('name') }}" placeholder="عنوان دسته" required>
                                    @error('name')
                                    <span class="alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="display_name">عنوان</label>
                                    <input type="text" class="form-control" id="display_name" name="display_name"
                                           value="{{ old('display_name') }}" placeholder="نام" required>
                                    @error('display_name')
                                    <span class="alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control">
                                    </textarea>

                                    @error('description')
                                    <span class="alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mr-2 btn-block ">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 box-margin">
{{--                @include('error-validation')--}}

                <div class="card">

                    <div class="card-body">
                        <h4 class="card-title mb-2">حق دسترسی</h4>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>عنوان</th>
                                    <th>توضیحات</th>
                                    <th style="width: 120px;">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $index => $permission)
                                    <tr>
                                        <td>{{ ++$index }}</td>

                                        <td>{{ $permission->name }}</td>

                                        <td>{{ $permission->display_name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit( $permission->description ,30)}}</td>
                                        <td>
                                            <a href="" data-toggle="modal"
                                               data-target="#rate-group-{{ $permission->id }}"><i
                                                    class="icon-pencil btn btn-primary btn-circle"></i></a>
                                            <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                  style="display: inline;" id="frm-delete-permission{{ $permission->id }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <a href="#"
                                                   onclick="deleteWithModal('frm-delete-permission', '{{ $permission->id }}', event)"><i
                                                        class="fa fa-trash btn btn-danger btn-circle"></i></a>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="rate-group-{{ $permission->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('permissions.update', $permission->id) }}" method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                {{ method_field('put') }}
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">ویرایش <span
                                                                class="text-danger">{{ $permission->name }}</span></h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">

                                                        <div class="row mb-2">
                                                            <label for="name" class="col-md-3">نام</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" id="title" name="name" min="5" max="197"
                                                                       value="{{ $permission->name }}" placeholder="نام گروه" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label for="name" class="col-md-3">نام</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" id="display_name" name="display_name" min="5" max="197"
                                                                       value="{{ $permission->display_name }}" placeholder="عنوان گروه" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label for="description" class="col-md-3">نام</label>
                                                            <div class="col-md-9">
                                                                <textarea class="form-control" id="description" name="description" cols="40"
                                                                          placeholder="توضیحات گروه"
                                                                          rows="5">{{ $permission->description }}</textarea>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-rounded btn-success">
                                                            ویرایش
                                                        </button>
                                                        <button type="button" class="btn btn-rounded btn-danger close-modal"
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

@endsection

