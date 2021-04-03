<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@include('front.layouts.head')

<body>

<div id="page-overlay">
    <div class="overlay-content">
        <i class="fa fa-duotone fa-spinner-third fa-spin fa-4x text-white"></i>
    </div>
</div>
@include('front.layouts.header')

<?php //_______________ Category Fixed __________________ ?>
<section class="cat-fixed-container">

    @foreach($cached_categories->whereNull('category_id') as  $cached_category)
        <div class="d-flex">

                <img src="{{asset($path_user.'img/cat-icon-1.svg').'?ver='.$ver}}" alt="">
                <p class="align-self-center">
                    <a href="{{route('category',['city'=>$selected_city,'cat'=>$cached_category->slug])}}">
                    {{$cached_category->name}}
                    </a>

                </p>

        </div>
    @endforeach
</section>

<?php //_______________ Support Fixed __________________ ?>
<section class="support-fixed-container">
    <div class="support-circle">
        <i class="fa-regular fa-user-headset"></i>
    </div>
    <div class="support-circle overlay_on">
        <i class="fa-regular fa-question"></i>
    </div>
    <div id="go_top" class="support-circle">
        <i class="fa-regular fa-angle-up"></i>
    </div>
</section>


<!-- _______________Body of content__________________________-->
@yield('content')

<!-- _______________Footer__________________________-->
@include('front.layouts.footer')

</body>
</html>
