<header>

    <!-- __________________________ Responsive Header __________________________ -->
    <section class="responsive-header w-100">
        <div class="responsive-header-container p-2">
            <div class="d-flex flex-column position-rlative">
                <div class="w-100 d-flex justify-content-between ">
                    <div class="align-self-center" type="button" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="false"><i class="fa-solid fa-bars"></i></div>

                    <ul class="dropdown-menu w-100">
                        @foreach($cashed_menus->where('menu','header') as $cashed_menu)
                            <li class="dropdown-item pt-3 menu-dropright"><a class="d-flex pl-2 pr-2 w-100"
                                                                             href="{{$cashed_menu->link}}">{{$cashed_menu->name}}</a>
                            </li>
                        @endforeach
                        <hr>

                        @foreach($cached_categories->whereNull('category_id') as  $cached_category)

                            <li class="dropdown-item pt-3 menu-dropright
                        @if($cached_category->categories_count >0)
                                dropdown-submenu
@endif
                                " id="{{$cached_category->id}}">

                                <a class="d-flex pl-2 pr-2 w-100"
                                   href="{{route('category',['city'=>$selected_city,'cat'=>$cached_category->slug])}}">
                                    <div><i class="fa-regular fa-turkey"></i></div>
                                    <div class="align-self-center pl-4">
                                        <div style="font-weight: 400;font-size: 1.1rem">
                                            {{$cached_category->name}}
                                        </div>
                                    </div>
                                    <!-- <div class="align-self-center"><i class="fa-regular fa-angle-down"></i></div> -->
                                </a>
                                @if($cached_category->categories_count >0)
                                    <ul class="dropdown-menu w-100">
                                        @foreach($cached_category->categories as $category)
                                            <li>
                                                <a href="{{route('category',['city'=>$selected_city,'cat'=>$category->slug])}}">
                                                    <div class="dropdown-item w-100 pt-3 pl-2">{{$category->name}}</div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif


                            </li>
                        @endforeach
                    </ul>
                    <div class="align-self-center"><img class="responsive-header-logo"
                                                        src="{{asset(trim($siteSettings['site_logo']->value_fa))}}"
                                                        alt=""></div>
                    <div class="align-self-center">
                        @include('front.layouts.cart')
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="search-form">
                        <form action="{{route('search.action',$selected_city)}}" class="p-relative d-flex">
                            <label class="mobile-header-select-city" for="header-city">
                                <i class="fa-solid fa-location-dot"></i>
                                <select class="header-city" name="city">
                                    @foreach($cached_places as $cached_place)
                                        <option value="{{$cached_place->slug}}"
                                            {{$cached_place->slug ==$selected_city?'selected':''}}
                                        >{{$cached_place->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <input autocomplete="off" id="mobileSearchInput"
                                   type="text" name="q" value="{{app('request')->input('q')}}" onkeyup="mobileSearch()">
                            <span><i class="fa-regular fa-magnifying-glass submit-search"></i></span>
                        </form>
                        <ul class="mobile-search-dropdown-menu" data-input="mobileSearchInput"
                            style="text-align: right;display: none !important;"></ul>
                    </div>
                    @auth()
                        <div class="tablet-header-btn align-self-center dropdown">
                            <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                ورود / ثبت نام
                            </button>
                            <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3"
                                style="left: 0;">
                                @if (Auth::check()&& Auth::user()->hasRole(['super_administrator']))
                                    <li><a class="dropdown-item" href="{{route('panel.dashboard')}}">داشبورد</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{route('logout')}}">خروج</a></li>

                            </ul>
                        </div>
                    @endauth
                    @guest()
                        <div class="tablet-header-btn align-self-center dropdown">
                            <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                ورود / ثبت نام
                            </button>
                            <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <li><a class="dropdown-item" href="{{route('login.form')}}">ورود</a></li>
                                <li><a class="dropdown-item" href="{{route('register.form')}}">ثبت نام</a></li>
                            </ul>
                        </div>

                    @endguest

                </div>
            </div>


        </div>
    </section>
</header>

@push('internal_js')


    <script>
        $('#mobileSearchInput').focusout(function () {
            setTimeout(function () {
                $('ul.mobile-search-dropdown-menu').hide();
            }, 400);
        });

        $(document).on('click', '.submit-search', function () {
            $(this).parents('form:first').submit()
        })

        function mobileSetValue(obj) {
            $('#mobileSearchInput').val($(obj).text());
        }

        function mobileSearch() {
            var str = $('#mobileSearchInput').val();

            dropdown = $('.mobile-search-dropdown-menu');
            dropdown.empty();
            dropdown.append('<li><a href="#"> در حال جستجو</a></li>');

            $.ajax({
                type: "get",
                url: "{{route('ajax.search',$selected_city)}}",
                data: {"q": str},
                success: function (response) {
                    if (response && response.length > 0) {
                        $('ul.mobile-search-dropdown-menu').show();
                        dropdown.empty();
                        for (let i = 0; i < response.length; i++) {
                            dropdown.append('<li><a  href="#" onclick="mobileSetValue(this);" class="search-dropdown text-secondary" >' + response[i].name + '</a></li>')
                        }

                    } else {

                        dropdown.empty();
                        $('.mobile-search-dropdown-menu').append('<li><a href="#">موردی پیدا نشد</a></li>');

                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    dropdown.empty();
                    $('.dropdown-menu').append('<li><a href="#">خطا</a></li>');
                }

            });
        }

    </script>
@endpush



