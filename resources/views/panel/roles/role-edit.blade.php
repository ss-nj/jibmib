<form action="{{ route('roles.update', $role->id) }}" method="post" class="ajax_validate"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">ویرایش سمت <span
                    class="text-danger">{{ $role->name }}</span></h4>
            <button type="button" class="close" data-dismiss="modal">

            </button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">

            <div class="form-group">
                <label for="name">عنوان(بهتر است از حروف انگلیسی و بدون فاصله استفاده شود) </label>
                <input type="text" class="form-control name" name="name"
                       title="عنوان(بهتر است از حروف انگلیسی و بدون فاصله استفاده شود)"
                       placeholder="عنوان(بهتر است از حروف انگلیسی و بدون فاصله استفاده شود)  "
                       value="{{ $role->name }}">
                <span class="error_field alert-danger" role="alert"> </span>

            </div>
            <div class="row mb-2">
                <label for="display_name"
                       class="col-md-3">{{__('roles.display name')}} </label>
                <div class="col-md-9">
                    <input type="text" class="form-control display_name"
                           name="display_name"
                           value="{{ $role->display_name }}"
                           placeholder="{{__('roles.display name')}} "
                    >
                    <span class="error_field alert-danger" role="alert"> </span>

                </div>
            </div>
            <div class="row mb-2">
                <label for="description"
                       class="col-md-3">{{__('roles.description')}} </label>
                <div class="col-md-9">
                                                                <textarea class="form-control description"
                                                                          name="description" cols="40"
                                                                          placeholder="{{__('roles.role description')}} "
                                                                          rows="5">{{ $role->description }}</textarea>
                    <span class="error_field alert-danger" role="alert"> </span>

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
<script>
    $('.select2').select2({
        placeholder: 'انتخاب کنید...',
        dir: 'ltr',
        allowClear: true,
    });
</script>

