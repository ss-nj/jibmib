<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ویرایش ویژگی </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="{{ route('category.attributes.update',$category->id) }}" class="ajax_validate">
            @csrf

            <div class="error_field text-danger"> </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="form-control-label">انتخاب ویژگی:</label>
                    <div class="form-group">
                        <select name="attribute_id[]" id="edit-attribute-id" multiple class="form-control select2">
                            @foreach($attributes as $attribute)

                                <option
                                    {{ in_array($attribute->id ,$category->attributes->pluck('id')->toArray()) ? 'selected' : '' }}
                                    value="{{$attribute->id}}">{{$attribute->title}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="error_field text-danger"> </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                <button type="submit" class="btn btn-primary">اصلاح ویژگی ها</button>
            </div>
        </form>

    </div>
</div>
<script>
    $('.select2').select2({
        placeholder: 'انتخاب کنید...',
        dir: 'ltr',
        allowClear: true,
    });
</script>
