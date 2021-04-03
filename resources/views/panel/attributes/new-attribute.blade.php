<div class="modal fade" id="new-attribute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافه کردن ویژگی جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('attribute.store') }}" class="ajax_validate">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="title" class="form-control-label">نام :</label>
                        <input type="text" class="form-control title" id="title" name="title"
                               title="نام"
                        >
                        <div class="error_field text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="validation_unit" class="form-control-label">واحد :</label>
                        <input type="text" class="form-control" id="validation_unit validation_unit" name="validation_unit"
                               title="واحد"
                        >
                        <div class="error_field text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="validation_length" class="form-control-label">طول :</label>
                        <input type="number" class="form-control" id="validation_length validation_length" name="validation_length"
                               title="طول"
                        >
                        <div class="error_field text-danger"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">نوع:</label>
                        <select name="field_type" id="field_type" class="form-control field_type " >
                            <option value="">انتخاب کنید</option>
                            @foreach(\App\Http\Commerce\Models\Attribute::TYPE_MAP as $key =>$type)
                                <option value="{{$key}}">{{$type}}</option>
                            @endforeach
                        </select>
                        <div class="error_field text-danger"></div>
                    </div>


                    <div class="form-group">
                        <label for="description" class="form-control-label">توضیحات :</label>
                        <textarea class="form-control description" id="description" name="description" cols="30"
                                  rows="5"></textarea>
                        <span class="invalid-feedback description_error" role="alert"></span>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ایجاد ویژگی</button>
                </div>
            </form>

        </div>
    </div>
</div>


