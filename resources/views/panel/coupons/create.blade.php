@extends('panel.layouts.master')

@section('title')
ایجاد تخفیف
@endsection


@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12 box-margin height-card">
                <div class="card card-body">
                    <h4 class="card-title">تخفیف جدید</h4>
                    <form action="{{ route('coupons.store') }}" method="post" enctype="multipart/form-data"
                          class="row ajax_validate" accept-charset="utf-8">
                        {{ csrf_field() }}
                        <div class="form-group col-sm-6">
                            <label for="name">نام تخفیف</label>
                            <input type="text" class="form-control name"
                                   name="name"
                                   id="name"
                                   title="نام تخفیف"
                                   placeholder="نام تخفیف">
                            <div class="error_field text-danger"></div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="code">کد تخفیف</label>
                            <input type="text" class="form-control code"
                                   title="کد تخفیف"
                                   name="code"
                                   id="code"
                                   minlength="4"
                                   placeholder="کد تخفیف">
                            <div class="error_field text-danger"></div>

                        </div>

                        <div class="form-group col-sm-6">
                            <label for="name">انتخاب نوع</label>

                            <select name="type" class="form-control type" id="type"
                                    title="نوع تخفیف">
                                <option name="type" {{!old('type')?'selected':''}}
                                value="{{\App\Http\Commerce\Models\Coupon::PERCENT}}"> درصد</option>
                                <option name="type" {{old('type')?'selected':''}}
                                value="{{\App\Http\Commerce\Models\Coupon::AMOUNT}}">مقدار</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 percent">
                            <label for="percent">درصد</label>
                            <input type="number" title="درصد" id="percent"
                                   class="form-control  percent"
                                   name="percent" min="0" max="100"
                                   placeholder="درصد">
                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-6 amount" style="display:none ">
                            <label for="amount">مقدار</label>
                            <input type="number" title="مقدار"
                                   class="form-control amount"
                                   name="amount"  id="amount" min="0" disabled
                                   placeholder="مقدار">
                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-6 limit_on_cart">
                            <label for="limit_on_cart">محدودیت سید</label>
                            <input type="number" title="محدودیت سید"
                                   class="form-control limit_on_discount"
                                   name="limit_on_cart" id="limit_on_cart" min="0"
                                   placeholder="محدودیت سید">
                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-6 limit_on_discount percent">
                            <label for="limit_on_discount">محدودیت تخفیف</label>
                            <input type="number" title="محدودیت تخفیف"
                                   class="form-control limit_on_discount percent"
                                   name="limit_on_discount" id="limit_on_discount" min="0"
                                   placeholder="محدودیت تخفیف">
                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-6">
                            <label for="start_time">زمان شروع</label>
                            <input type="text"
                                   class="range-from-example form-control start_time"
                                   name="start_time" id="start_time" title="زمان شروع"
                                   placeholder="زمان شروع"
                            >

                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-6">
                            <label for="expire_time">زمان پایان</label>
                            <input type="text" title="زمان پایان"
                                   class="range-to-example form-control expire_time"
                                   name="expire_time" id="expire_time"
                                   placeholder="زمان پایان"
                            >

                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-6">
                            <label for="name">محدوده ی تاثیر</label>

                            <select name="effect_zone" class="form-control effect_zone" id="effect_zone"
                                    title="محدوده ی تاثیر">
                                <option name="type"
                                        value="{{\App\Http\Commerce\Models\Coupon::ALL}}"> همه
                                </option>
                                <option name="type"
                                        value="{{\App\Http\Commerce\Models\Coupon::TAKHFIFS}}">کوپن ها
                                </option>
                                <option name="type"
                                        value="{{\App\Http\Commerce\Models\Coupon::CATEGORIES}}">دسته ها
                                </option>

                            </select>
                        </div>

                        <div class="form-group col-sm-6 effect_zone_takhfifs" style="display:none">
                            <label for="name">انتخاب کوپن</label>

                            <select multiple name="takhfifs[]" id="takhfifs"
                                    title="انتخاب کوپن"
                                    class="form-control takhfifs-select2 takhfifs effect_zone_takhfifs"
                                    style="width: 100%;">

                            </select>
                        </div>
                        <div class="form-group col-sm-6 effect_zone_categories" style="display:none">
                            <label for="name">انتخاب دسته بندی</label>

                            <select  name="categories[]" id="categories"
                                    title="انتخاب دسته بندی"
                                    class="form-control categories_select2 effect_zone_categories categories"
                                    style="width: 100%;">

                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="count">تعداد</label>
                            <input type="number" title="تعداد"
                                   class="form-control count"
                                   name="count" id="count" min="0"
                                   placeholder="تعداد"
                            >
                            <div class="error_field text-danger"></div>

                        </div>
                        <div class="form-group col-sm-12 mb-20">
                            <label for="description"> توضیح </label>
                            <textarea name="description"  id="description" class="form-control description" title="توضیح"
                                      placeholder="توضیح">
                                      </textarea>
                            <div class="error_field text-danger"></div>

                        </div>

                        <button type="submit"
                                class="btn btn-primary mr-2 btn-block ">ارسال</button>
                    </form>
                </div>
            </div>

            <!-- end col -->

        </div>

        <!-- end row -->
    </div>

@endsection


@push('internal_js')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#type').change(function () {
            let valueSelected = $(this).val();
            changeFocous(valueSelected);

        });

        function changeFocous(valueSelected) {
            var percent = $(".percent");
            var amount = $(".amount");
            if (valueSelected == 0) {
                percent.fadeIn('slow');
                amount.hide();
                amount.prop('disabled', true);
                percent.prop('disabled', false);
            }
            if (valueSelected == 1) {
                amount.fadeIn('slow');
                percent.hide();
                percent.prop('disabled', true);
                amount.prop('disabled', false);
            }
        }


        $('#effect_zone').change(function () {
            let valueSelected = $(this).val();
            changeFocous2(valueSelected);

        });

        function changeFocous2(valueSelected) {

            var takhfifs = $(".effect_zone_takhfifs");
            var categories = $(".effect_zone_categories");
            if (valueSelected == 2) {
                takhfifs.fadeIn('slow');
                categories.hide();
                categories.prop('disabled', true);
                takhfifs.prop('disabled', false);
            }
            if (valueSelected == 1) {
                categories.fadeIn('slow');
                takhfifs.hide();
                takhfifs.prop('disabled', true);
                categories.prop('disabled', false);
            }
            if (valueSelected == 0) {
                categories.hide();
                takhfifs.hide();
                takhfifs.prop('disabled', true);
                categories.prop('disabled', true);
            }
        }
        $('.takhfifs-select2').select2({
            dir: "rtl",
            language: "fa",
            placeholder: 'یک یا چند کوپن را انتخاب کنید',
            allowClear: true,
            ajax: {
                url: '{{route('ajax.takhfifs.list')}}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.categories_select2').select2({
            dir: "rtl",
            language: "fa",
            placeholder: 'یک یا چند دسته را انتخاب کنید',
            allowClear: true,
            ajax: {
                url: '{{route('ajax.categories.list')}}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

    </script>
@endpush





