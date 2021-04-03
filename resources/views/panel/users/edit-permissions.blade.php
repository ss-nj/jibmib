<form action="{{ route('user.permissions.sync', $user->id) }}"
      method="post"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">{{__('roles.edit')}} <span
                        class="text-danger">{{ $user->name }}</span></h4>
            <button type="button" class="close" data-dismiss="modal">
                &times;
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
                                    {{ in_array($permission->id ,$user->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
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
<script>
     $('.kt-select2').select2({
    placeholder: 'انتخاب کنید...',
    dir: 'rtl',
    allowClear: true,
});
</script>
