<form action="{{ route('refunds.update', $refund->id) }}" method="post" autocomplete="off"
      class="editForm ajax_validate"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">ویرایش درخواست<span
                    class="text-danger">{{ $refund->name }}</span></h4>
            <button type="button" class="close" data-dismiss="modal">

            </button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <div class="form-group">
                <label for="amount">مقدار</label>

                <input type="text"
                       class="form-control amount"
                       name="amount"
                       title="مقدار"
                       id="amount"
                       value="{{$refund->amount}}"
                       autocomplete="name" autofocus
                       placeholder="مقدار">
                <div class="error_field text-danger">  </div>
            </div>

            <div class="form-group">
                <label for="bank_id">شماره حساب</label>

                <input type="text"
                       class="form-control bank_id"
                       name="bank_id"
                       title="شماره حساب"
                       value="{{$refund->bank_id}}"
                       id="bank_id"
                       autocomplete="bank_id" autofocus
                       placeholder="شماره حساب">
                <div class="error_field text-danger">  </div>
            </div>

            <div class="form-group">
                <label for="description">توضیحات</label>

                <textarea name="description" class="form-control description" cols="30" rows="10">{!! $refund->description !!}</textarea>
                <div class="error_field text-danger">  </div>
            </div>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
            <button type="submit" class="btn btn-primary">ایجاد درخواست</button>
        </div>
    </div>
</form>
    <script>
        $('.select2').select2({
            multiple: false,
            placeholder: 'انتخاب کنید...',
            dir: 'rtl',
            allowClear: true,
        });

    </script>
