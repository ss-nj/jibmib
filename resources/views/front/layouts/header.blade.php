<header>
    <section class="primary-header">
        <img src="{{asset($path_user.'img/top.png').'?ver='.$ver}}" alt="">
        <div class="content-container">
            <div class="primary-header-container po-relative row">
                <div class="col-3 align-self-center text-center">
                    <a href="{{route('home')}}">
                    <img class="primary-header-logo" src="{{asset(trim($siteSettings['site_logo']->value_fa))}}" alt="">
                    </a>
                </div>
                <div class="col-9">
                    <div class="d-flex justify-content-center w-100" style="float: left;">
                        <div class="search-form">
                            <form action="{{route('search.action',$selected_city)}}" id="select-city-form" class="p-relative">
                                <label class="header-select-city" for=""><i class="fa-solid fa-location-dot"></i>
                                    <select id="" class="header-city" name="city" id="">
                                        @foreach($cached_places as $cached_place)
                                        <option value="{{$cached_place->slug}}"
                                            {{$cached_place->slug ==$selected_city?'selected':''}}
                                        >{{$cached_place->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </label>
                                <input type="text"   autocomplete="off"
                                       name="q" value="{{app('request')->input('q')}}" onkeyup="search()"  id="searchStationInput"
                                >
                                <input type="submit" value="جستجو">
                            </form>
                            <ul class="search-dropdown-menu " data-input="searchStationInput"
                                style="text-align: right;display: none !important;"></ul>
                        </div>
                        @if(auth()->guard('shop')->check())
                            <div class="primary-header-btn">
                                <div class="text-center"><span><i class="fas fa-phone"></i></span> شماره تماس ویژه</div>

                                <div class="align-self-center dropdown">
                                    <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span style="margin: 0 3px;"><i class="fas fa-user"></i></span> پروفایل
                                    </button>
                                    <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        @if(auth()->guard('web')->check())
                                            @if ( auth()->user()->hasRole(['super_administrator']))
                                                <li><a class="dropdown-item" href="{{route('panel.dashboard')}}">داشبورد مدیریت</a></li>
                                            @endif
                                            <li><a class="dropdown-item" href="{{route('profile.index')}}">پروفایل کاربری</a></li>
                                            <li><a class="dropdown-item" href="{{route('user.tickets.index')}}">پشتیبانی</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{route('shop.dashboard')}}">داشبورد</a></li>
                                        <li><a class="dropdown-item" href="{{route('shop.profiles.index')}}">پروفایل کسب و کار</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="primary-header-btn">
                                <div class="text-center">031 - 35 144</div>
                                <a href="{{route('logout')}}"><div class="theme-btn green-btn">خروج</div></a>
                            </div>
                        @elseif(auth()->guard('web')->check())
                            <div class="primary-header-btn">
                                <div class="text-center"><span><i class="fas fa-phone"></i></span> شماره تماس ویژه</div>

                                <div class="align-self-center dropdown">
                                    <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span style="margin: 0 3px;"><i class="fas fa-user"></i></span> پروفایل
                                    </button>
                                    <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        @if ( auth()->user()->hasRole(['super_administrator']))
                                            <li><a class="dropdown-item" href="{{route('panel.dashboard')}}">داشبورد</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{route('profile.index')}}">پروفایل</a></li>
                                        <li><a class="dropdown-item" href="{{route('user.tickets.index')}}">پشتیبانی</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="primary-header-btn">
                                <div class="text-center">031 - 35 144</div>
                                <a href="{{route('logout')}}"><div class="theme-btn green-btn">خروج</div></a>
                            </div>
                        @else
                            <div class="primary-header-btn">
                                <div class="text-center"><span><i class="fas fa-phone"></i></span> شماره تماس ویژه</div>
                                <div class="align-self-center dropdown">
                                    <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span style="margin: 0 3px;"><i class="fas fa-user"></i></span> ورود به سامانه
                                    </button>
                                    <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <li><a class="dropdown-item" href="{{route('login.form')}}">بخش کاربری</a></li>
                                        <li><a class="dropdown-item" href="{{route('shop.login.form')}}">ورود به کسب و کار</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="primary-header-btn">
                                <div class="text-center">031 - 35 144</div>
                                <a href="{{route('register.form')}}"><div class="theme-btn green-btn">ثبت نام</div></a>
                            </div>

                        @endif

                    </div>

                </div>
                 @include('front.layouts.top-menu')
                <div class="col-2 shop-cart">
                    @include('front.layouts.cart')

                </div>
            </div><!-- primary-header-container -->
        </div>
    </section><!--.primary-header-->

    <!-- __________________________ Responsive Header __________________________ -->
    @include('front.layouts.responsive-header')
</header>

@push('internal_js')
    <script >
        $(document).on('change','.header-city',function () {
            let valueSelected = $(this).val();
            let Url = "{{route('city.select')}}" +'?city='+valueSelected

            window.location.replace(Url);

            // $('#select-city-form').submit();
            // $(this).parents('form:first').submit()
        })
    </script>

    <script>
        $('#searchStationInput').focusout(function () {

            setTimeout(function () {
                $('ul.search-dropdown-menu').hide();
            }, 400);

        });

        function setValue(obj) {
            $('#searchStationInput').val($(obj).text());

        }

        function search() {

            var str = $('#searchStationInput').val();
            dropdown = $('.search-dropdown-menu');
            dropdown.empty();
            dropdown.append('<li><a href="#"> در حال جستجو</a></li>');
            $('.dropdown').dropdown();
            $.ajax({
                type: "get",
                url: "{{route('ajax.search',$selected_city)}}",
                data: {"q": str},
                success: function (response) {
                    if (response && response.length > 0) {
                        $('ul.search-dropdown-menu').show();
                        dropdown.empty();
                        for (let i = 0; i < response.length; i++) {
                            dropdown.append('<li><a  href="#" onclick="setValue(this);document.getElementById(\'top-search\').submit()" class="search-dropdown text-secondary" >' + response[i].name + '</a></li>')
                        }

                        $('.dropdown').dropdown();

                    } else {

                        dropdown.empty();
                        $('.search-dropdown-menu').append('<li><a href="#">موردی پیدا نشد</a></li>');

                    }


                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    dropdown.empty();
                    $('.dropdown-menu').append('<li><a href="#">خطا</a></li>');
                }

            }).done(function (response) {
            });
        }

    </script>
@endpush

@push('style')
    <style>
        .search-dropdown-menu{
            text-align: right;
            position: absolute;
            background-color: #fff;
            border: solid;
            padding: 16px;
            z-index: 9999999;
            width: 600px;
        }
    </style>
@endpush


