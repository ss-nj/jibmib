<header>
    <section class="primary-header">
        <img src="{{asset($path_user.'img/top.png').'?ver='.$ver}}" alt="">
        <div class="content-container">
            <div class="primary-header-container po-relative row">
                <div class="col-3 align-self-center text-center"><img class="primary-header-logo" src="{{asset(trim($siteSettings['site_logo']->value_fa))}}" alt=""></div>
                <div class="col-9">
                    <div class="d-flex justify-content-center w-100" style="float: left;">
                        <div class="search-form">
                            <form action="{{route('city.select')}}" id="select-city-form" class="p-relative">
                                <label class="header-select-city" for="header-city"><i class="fa-solid fa-location-dot"></i>
                                    <select id="header-city" name="city" id="">
                                        @foreach($cached_places as $cached_place)
                                        <option value="{{$cached_place->slug}}"
                                            {{$cached_place->slug ==$selected_city?'selected':''}}
                                        >{{$cached_place->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </label>
                                <input type="text">
                                <input type="submit" value="جستجو">
                            </form>
                        </div>
                        @auth()
                        <div class="primary-header-btn">
                            <div class="text-center"><span><i class="fas fa-phone"></i></span> شماره تماس ویژه</div>

                            <div class="align-self-center dropdown">
                                <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span style="margin: 0 3px;"><i class="fas fa-user"></i></span> پروفایل
                                </button>
                                <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                    @if (Auth::check()&& Auth::user()->hasRole(['super_administrator']))
                                        <li><a class="dropdown-item" href="{{route('panel.dashboard')}}">داشبورد</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{route('profile.index')}}">پروفایل</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="primary-header-btn">
                            <div class="text-center">031 - 35 144</div>
                            <a href="{{route('logout')}}"><div class="theme-btn green-btn">خروج</div></a>
                        </div>
                        @endauth
                        @guest()
                            <div class="primary-header-btn">
                                <div class="text-center"><span><i class="fas fa-phone"></i></span> شماره تماس ویژه</div>
                                <a href="{{route('login.form')}}"><div class="theme-btn orange-btn"><span style="margin: 0 3px;"><i class="fas fa-user"></i></span> ورود به سامانه</div></a>
                            </div>
                            <div class="primary-header-btn">
                                <div class="text-center">031 - 35 144</div>
                                <a href="{{route('register.form')}}"><div class="theme-btn green-btn">ثبت نام</div></a>
                            </div>

                        @endguest

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
    <section class="responsive-header w-100">
        <div class="responsive-header-container p-2">
            <div class="d-flex flex-column position-rlative">
                <div class="w-100 d-flex justify-content-between ">
                    <div class="align-self-center" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></div>
                    
                    <ul class="dropdown-menu w-100">
                        @foreach($cashed_menus as $cashed_menu)
                            <li class="dropdown-item pt-3 menu-dropright"><a class="d-flex pl-2 pr-2 w-100" href="{{$cashed_menu->link}}">{{$cashed_menu->name}}</a></li>
                        @endforeach
                        <hr>
                        
                        @foreach($cached_categories->whereNull('category_id') as  $cached_category)
                        
                        <li class="dropdown-item pt-3 menu-dropright
                        @if($cached_category->categories_count >0)
                            dropdown-submenu 
                            @endif
                        " id="{{$cached_category->id}}">
                            
                            <a class="d-flex pl-2 pr-2 w-100"  href="{{route('category',['city'=>$selected_city,'cat'=>$cached_category->slug])}}">
                                <div><i class="fa-regular fa-turkey"></i></div>
                                <div class="align-self-center pl-4">
                                    <div  style="font-weight: 400;font-size: 1.1rem" >
                                    {{$cached_category->name}}
                                    </div>
                                </div>
                                <!-- <div class="align-self-center"><i class="fa-regular fa-angle-down"></i></div> -->
                            </a>
                            @if($cached_category->categories_count >0)
                            <ul class="dropdown-menu w-100">
                                @foreach($cached_category->categories as $category)
                                    <li><a href="{{route('category',['city'=>$selected_city,'cat'=>$category->slug])}}">
                                        <div class="dropdown-item w-100 pt-3 pl-2">{{$category->name}}</div>
                                    </a>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                            
                            
                        </li>
                        @endforeach
                    </ul>
                    <div class="align-self-center"><img class="responsive-header-logo" src="{{asset(trim($siteSettings['site_logo']->value_fa))}}" alt=""></div>
                    <div class="align-self-center">
                       @include('front.layouts.cart')
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="search-form">
                        <form action="#" class="p-relative d-flex">
                            <label class="mobile-header-select-city" for="header-city">
                                <i class="fa-solid fa-location-dot"></i>
                                <select id="header-city" name="city" id="">
                                    <option value="0"></option>
                                    @foreach($cached_places as $cached_place)
                                    <option value="{{$cached_place->slug}}">
                                    {{$cached_place->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </label>
                            <input class="mobile-search-text" type="text"><span><i class="fa-regular fa-magnifying-glass"></i></span>
                        </form>
                    </div>
                    @auth()
                        <div class="tablet-header-btn align-self-center dropdown">
                            <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                ورود / ثبت نام
                            </button>
                            <ul id="dropdownMenuButton3-1" class="dropdown-menu" aria-labelledby="dropdownMenuButton3" style="left: 0;">
                                @if (Auth::check()&& Auth::user()->hasRole(['super_administrator']))
                                    <li><a class="dropdown-item" href="{{route('panel.dashboard')}}">داشبورد</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{route('logout')}}">خروج</a></li>

                            </ul>
                        </div>
                    @endauth
                    @guest()
                        <div class="tablet-header-btn align-self-center dropdown">
                            <button class="theme-btn orange-btn dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
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
    <script >
        $(document).on('change','#header-city',function () {
            $('#select-city-form').submit();
        })
    </script>
@endpush


