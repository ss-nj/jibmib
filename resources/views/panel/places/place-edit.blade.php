<form action="{{ route('places.update', $place->id) }}" method="post" autocomplete="off"
      class="editForm ajax_validate"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">ویرایش منطقه<span
                    class="text-danger">{{ $place->name }}</span></h4>
            <button type="button" class="close" data-dismiss="modal">

            </button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">

            <div class="form-group">
                <label for="name">نام</label>

                <input type="text"
                       class="form-control name"
                       name="name"
                       id="name"
                       value="{{ $place->name }}"
                       autocomplete="name" autofocus
                       placeholder="نام">
                <div class="error_field text-danger"> </div>
            </div>

            <div class="form-group">
                <label for="slug">نامک(قسمت انتهایی لینک صفحه)</label>

                <input type="text"
                       class="form-control slug"
                       value="{{ $place->slug }}"
                       name="slug"
                       id="slug"
                       autocomplete="slug" autofocus
                       placeholder="نامک(قسمت انتهایی لینک صفحه)"/>
                <div class="error_field text-warning">
                    <h6>نامک بعد از ذخیره ممکن است تغییر کند!! (حدف موارد غیر مجاز)</h6>
                </div>
                <div class="error_field text-danger">
                    @error('mobile')
                    {{ $message }}
                    @enderror
                </div>
            </div>


            <div class="form-group" >
                <label for="mobile">استان</label>

                <select class="form-control  select-province province_id" style="width: 100%"
                        oninvalid="setCustomValidity('لطفا یکی از موارد را انتخاب کنید ')"
                        onchange="try{setCustomValidity('')}catch(e){}"
                        title="استان را انتخاب کنید"
                        id="select-province"  name="province_id">
                </select>
                <div class="error_field text-danger"></div>

            </div>

            <div class="form-group">
                <label for="select-city">شهرها</label>

                <select class="form-control  select-city city_id" style="width: 100%"
                        oninvalid="setCustomValidity('لطفا یکی از موارد را انتخاب کنید ')"
                        onchange="try{setCustomValidity('')}catch(e){}"
                        title="شهر را انتخاب کنید"
                        id="select-city" name="city_id">
                </select>
                <div class="error_field text-danger">
                </div>

            </div>

        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-rounded btn-success">
                ذخیره
            </button>
            <button type="button" class="btn btn-rounded btn-danger close-modal"
                    data-dismiss="modal">بستن
            </button>
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
        // $(document).ready(function () {
            loadProvinces();
        // });

        $('.select-province').change(function () {

            loadCities($(this));
        });

        function loadProvinces() {

            dropdown = $('.editForm .select-province');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');
            $.ajax({
                type: "get",
                url: "{{url('provinces')}}",
                // data: {"city-price": valueSelected},

                success: function (response) {

                    if (response.data && response.data.length > 0) {

                        // dropdown.prop('required', true);

                        dropdown.empty();
                        dropdown.append('<option  value=""  disabled>استان مورد نظر را انتخاب کنید</option>');

                        dropdown.prop('selectedIndex', 0);
                        for (let i = 0; i < response.data.length; i++) {
                            dropdown.append($('<option>')
                                .attr('value', response.data[i].id)
                                .text(response.data[i].name));
                        }

                    } else {
                        dropdown.empty();
                        dropdown.append('<option selected disabled>بدون مقدار</option>');
                        // dropdown.prop('required', false);
                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
                $('.editForm .select-province option').each(function () {
                    console.log(this.value)
                    if (this.value == {{$place->city?$place->city->province->id:99999999999999}}) {

                        this.selected = true;
                        $('.editForm .select-province').trigger('change');
                        return false; // stop searching after we find the first match
                    }
                });
            });
        }

        function loadCities(thisObj) {

            let valueSelected = thisObj.val();
            if (!valueSelected) return;
            dropdown = $('.editForm .select-city');
            dropdown.empty();
            dropdown.append('<option selected disabled>در حال بارگزاری</option>');

            $.ajax({
                type: "get",
                url: "{{url('cities')}}",

                data: {"province_id": valueSelected},
                success: function (response) {

                    if (response.data.length > 0) {
                        dropdown.prop('required', true);

                        dropdown.empty();
                        dropdown.append('<option  value="" selected disabled>انتخاب کنید</option>');

                        dropdown.prop('selectedIndex', 0);
                        for (var i = 0; i < response.data.length; i++) {
                            dropdown.append($('<option></option>')
                                .attr('value', response.data[i].id)
                                .text(response.data[i].name));
                        }
                    } else {
                        dropdown.empty();
                        dropdown.append('<option selected disabled>بدون مقدار</option>');
                        // dropdown.prop('required', false);

                    }


                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {

                }

            }).done(function (response) {
                $('.editForm .select-city option').each(function () {
                    if (this.value == {{$place->city_id}}) {

                        this.selected = true;
                        $('.editForm .select-city').trigger('change');
                        return false; // stop searching after we find the first match
                    }
                });
            });
        }
    </script>
