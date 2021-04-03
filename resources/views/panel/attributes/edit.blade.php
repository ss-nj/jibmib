<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ویرایش ویژگی</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="{{ route('attribute.update',$attribute->id) }}" class="ajax_validate">
            @csrf
            @method('put')
            <div class="modal-body">

                <div class="form-group">
                    <label for="title" class="form-control-label">نام :</label>
                    <input type="text" class="form-control title" id="title" name="title"
                           title="نام"
                           value="{{$attribute->title}}"
                    >
                    <div class="error_field text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="validation_unit" class="form-control-label">واحد :</label>
                    <input type="text" class="form-control validation_unit" id="validation_unit" name="validation_unit"
                           title="واحد"
                           value="{{$attribute->validation_unit}}"

                    >
                    <div class="error_field text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="validation_length" class="form-control-label">طول :</label>
                    <input type="number" class="form-control validation_length" id="validation_length" name="validation_length"
                           title="طول"
                           value="{{$attribute->validation_length}}"
                    >
                    <div class="error_field text-danger"></div>
                </div>
                <div class="form-group">
                    <label for="field_type" class="form-control-label">نوع:</label>
                    <select name="field_type" id="field_type" class="form-control field_type" >
                        <option value="">انتخاب کنید</option>
                        @foreach(\App\Http\Commerce\Models\Attribute::TYPE_MAP as $key =>$type)
                            <option {{$attribute->field_type==$key?'selected':''}} value="{{$key}}">{{$type}}</option>
                        @endforeach
                    </select>
                    <div class="error_field text-danger"></div>
                </div>


                <div class="form-group">
                    <label for="description" class="form-control-label">توضیحات :</label>
                    <textarea class="form-control description" id="description" name="description" cols="30"
                              rows="5">{!! $attribute->description!!}</textarea>
                    <span class="invalid-feedback description_error" role="alert"></span>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                <button type="submit" class="btn btn-primary">ویرایش ویژگی</button>
            </div>
        </form>

    </div>
</div>
