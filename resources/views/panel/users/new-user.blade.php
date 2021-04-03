<div class="modal fade" id="new-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">اضافه کردن کاربر جدید </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('users.store') }}" class="ajax_validate">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="first_name">نام</label>

                        <input  type="text"
                                class="form-control first_name"
                                name="first_name"
                                id="first_name"
                                autocomplete="first_name" autofocus
                                placeholder="نام">
                        <div class="error_field text-danger"> </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name">نام خانوادگی</label>

                        <input  type="text"
                                class="form-control last_name"
                                name="last_name"
                                id="last_name"
                                autocomplete="assd" autofocus
                                placeholder="نام خانوادگی"/>
                        <div class="error_field text-danger"> </div>

                    </div>

                    <div class="form-group">
                        <label for="">گذرواژه</label>

                        <input
                            class="form-control password" autocomplete=""
                            name="password" id="" type="password"
                            placeholder="گذرواژه">
                        <div class="error_field text-danger"> </div>

                    </div>

                    <div class="form-group">
                        <label for="mobile">شماره موبایل</label>

                        <input  type="tel"
                                placeholder="شماره موبایل"
                                pattern="^09[0-9]{9}$"
                                title="شماره همراه را وارد کنید"
                                class="form-control mobile"
                                name="mobile"
                                id="mobile"
                                  >
                        <div class="error_field text-danger"> </div>

                    </div>

                    <div class="form-group">
                        <label for="mobile">سمت</label>

                        <select multiple name="roles[]"  id="roles[]"
                                class="form-control select2 roles"
                                style="width: 100%;">

                            @if($roles)
                                @foreach($roles as $role)
                                    <option
                                        value="{{$role->id}}"
                                    >
                                        {{$role->display_name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                        <div class="error_field text-danger"> </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">ایجاد کاربر</button>
                </div>
            </form>

        </div>
    </div>
</div>


