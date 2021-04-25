<div
    class="sticky-wrapper sticky-wrapper-transparent sticky-wrapper-effect-1 sticky-wrapper-border-bottom d-none d-lg-block d-xl-none"
    data-plugin-sticky data-plugin-options="{'minWidth': 0, 'stickyStartEffectAt': 100, 'padding': {'top': 0}}">
    <div class="sticky-body">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-9">
                    <div class="py-4">
                        <a href="{{route('shop.dashboard')}}">
                            <img class="ml-2" alt="" width="82" height="40" data-change-src="" src="">
                        </a>
                    </div>
                </div>
                <div class="col-3 text-right">
                    <button class="hamburguer-btn" data-set-active="false">
									<span class="hamburguer">
										<span></span>
										<span></span>
										<span></span>
									</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<header id="header" class="side-header d-flex" style="">
    <div class="header-body">
        <div class="header-container container d-flex h-100" style="overflow-x: hidden">
            <div class="header-column flex-row flex-lg-column justify-content-center h-100">
                <div class="header-row flex-row justify-content-start justify-content-lg-center py-lg-5">
                    <h1 class="header-logo">

                        {{--                        <img class="icon-animated" width="45" src="{{asset($path.'vendor/linea-icons/linea-basic/icons/home.svg')}}" alt="" data-icon="" data-plugin-options="{'color': '#0088cc', 'animated': true, 'delay': 600, 'strokeBased': true}" style="opacity: 1;">--}}
                        <a href="{{route('shop.dashboard')}}">
                            <img alt="" width="100" height="48"
                                 src="{{asset($siteSettings['site_logo']->value_fa).'?ver='.$ver}}">
                            <span class="hide-text">داشبورد فروشندگان</span>
                        </a>
                    </h1>
                </div>
                <div class="header-row header-row-side-header flex-row h-100 pb-lg-5">
                    <div
                        class="header-nav header-nav-links header-nav-links-side-header header-nav-links-vertical header-nav-links-vertical-columns align-self-center">
                        <div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders">
                            <nav class="collapse">
                                <ul class="nav nav-pills" id="mainNav">
                                    <li class="dropdown">
                                        <img class="icon-animated" width="45"
                                             src="{{asset($path.'vendor/linea-icons/linea-basic/icons/home.svg')}}"
                                             alt="" data-icon=""
                                             data-plugin-options="{'color': '#0088cc', 'animated': true, 'delay': 600, 'strokeBased': true}"
                                             style="opacity: 1;">
                                        <a class="dropdown-item dropdown-toggle active"
                                           href="{{route('shop.dashboard')}}">

                                            داشبورد
                                        </a>
                                        <ul class="dropdown-menu" style="position: fixed;">
                                            <li>
                                                <a class="dropdown-item" href="{{route('shop.profiles.index')}}">
                                                    پروفایل فروشگاه
                                                </a>
                                            </li>
 <li>
                                                <a class="dropdown-item" href="{{route('shop.licences.index')}}">
                                                    پروفایل مدارک
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <img class="icon-animated" width="45"
                                             src="{{asset($path.'vendor/linea-icons/linea-ecommerce/icons/gift.svg')}}"
                                             alt="" data-icon=""
                                             data-plugin-options="{'color': '#0088cc', 'animated': true, 'delay': 600, 'strokeBased': true}"
                                             style="opacity: 1;">
                                        <a class="dropdown-item dropdown-toggle active"
                                           href="{{route('shop.takhfifs.index')}}">

                                            مدیریت تخفیفات
                                        </a>
                                        <ul class="dropdown-menu" style="position: fixed;">
                                            <li>
                                                <a class="dropdown-item" data-toggle="modal"
                                                   data-target="#new-takhfif">
                                                    ایجاد تخفیف
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('shop.takhfifs.index')}}">
                                                    مدیریت تخفیفات
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <li class="">
                                        <img class="icon-animated" width="45"
                                             src="{{asset($path.'vendor/linea-icons/linea-ecommerce/icons/money.svg')}}"
                                             alt="" data-icon=""
                                             data-plugin-options="{'color': '#0088cc', 'animated': true, 'delay': 600, 'strokeBased': true}"
                                             style="opacity: 1;">
                                        <a class="dropdown-item dropdown-toggle active"
                                           href="{{route('shop.transactions.index')}}">

                                            مدیریت مالی
                                        </a>

                                    </li>
                                    <li class="">
                                        <img class="icon-animated" width="45"
                                             src="{{asset($path.'vendor/linea-icons/linea-ecommerce/icons/cart.svg')}}"

                                             alt="" data-icon=""
                                             data-plugin-options="{'color': '#0088cc', 'animated': true, 'delay': 600, 'strokeBased': true}"
                                             style="opacity: 1;">
                                        <a class="dropdown-item dropdown-toggle active"
                                           href="{{route('shop.coupon.index')}}">

                                           ابطال کوپن
                                        </a>

                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="header-row justify-content-end pb-lg-3">
{{--                    <ul class="header-social-icons social-icons d-none d-sm-block social-icons-clean d-sm-0">--}}
{{--                        <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank"--}}
{{--                                                             title="Facebook"><i class="fab fa-facebook-f"></i></a></li>--}}
{{--                        <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank"--}}
{{--                                                            title="Twitter"><i class="fab fa-twitter"></i></a></li>--}}
{{--                        <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank"--}}
{{--                                                             title="Linkedin"><i class="fab fa-linkedin-in"></i></a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                    <p class="d-none d-lg-block text-1 pt-3">ارائه شده در وب‌سایت طراحان ایرانیان</p>
                    <button class="btn header-btn-collapse-nav" data-toggle="collapse"
                            data-target=".header-nav-main nav">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>


