@extends('panel.layouts.master')

@section('title')
     کاربران
@endsection

@section('style')
    <style>
        #icon-show {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .col-md-10, a {
            font-weight: bold;
        }
        .col-md-2, .edit {font-family: irsans-b;}

        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    <div id="content" class="app-content box-shadow-z2 bg pjax-container" role="main">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>جزئیات پروفایل کاربر</h5>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0;">
                <div class="box-body">
{{--                    @include('error-validation')--}}
{{--                    @include('success-message')--}}
                    <div class="row">
                        <div class="col-12">

                                <img src="{{ asset( $user->image->path) }}" id="icon-show">

                        </div>
                    </div>
                    <br><br><br>
                    <div class="form-group row">
                        <p class="col-md-2 leftTxt">نام و نام خانوادگی : </p>
                        <p class="col-md-3 Bold">{{ $user->name }}</p>

                    </div>
                    <div class="form-group row">
                        <p class="col-md-2 leftTxt">شماره موبایل : </p>
                        <p class="col-md-3 Bold">
                            {{ $user->mobile }}
                            <span class="label rounded {{ isset($user->mobile_verified_at) ? 'alert alert-success' : 'alert alert-danger' }}">{{ isset($user->mobile_verified_at )? 'فعال' : 'غیرفعال' }}</span>
                        </p>
                        <p class="col-md-2 leftTxt">ایمیل : </p>
                        <p class="col-md-4 Bold">
                            {{ $user->email }}
                        </p>
                    </div>
                    <div class="form-group row">
                        <p class="col-md-2 leftTxt">وضعیت کاربر : </p>
                        <p class="col-md-3">
                            <span
                                class="label rounded {{ $user->is_deleted == 0 ? 'alert alert-success' : 'alert alert-danger' }}">{{ $user->is_deleted == 0 ? 'فعال' : 'غیرفعال' }}
                            </span>&nbsp;

                        </p>
                    </div>

                    <div class="form-group row">
                        <p class="col-md-2 leftTxt">تیکت ها : </p>
                        <p class="col-md-4"><span class="{{ $user->tickets->count()==0?'text-warning':'text-info'}}">{{ $user->tickets->count()}}</span>
                            @if( $user->tickets->count()>0)
{{--                                <a href="{{ route('ticket.index', ['user' => $user->id]) }}" class="underline edit"> مشاهده </a></p>--}}
                        @endif
                    </div>



                    <div class="form-group row">
                        <p class="col-md-2">
                            <a class="btn btn-info btn-rounded" href="{{route('users.index')}}" style="font-family: IRANSans">بازگشت</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#province').change(function () {
                let province = $(this);
                let city = $('#city');

                $.ajax({
                    url: '{{ url('get-cities-by-ajax') }}',
                    type: 'get',
                    data: {
                        'province' : province.val(),
                    },

                    success: function (response) {

                        let list = response.cities;
                        city.html('<option selected disabled>انتخاب شهر</option>');
                        for ( let i = 0 ; i < list.length ; i++ )
                            city.append('<option value="'+ list[i].id +'">'+ list[i].name +'</option>');
                    },
                });

            });
        })
    </script>

@endsection

