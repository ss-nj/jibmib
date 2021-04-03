@if($home_banner[$no])
    <a href="{{$home_banner[$no]->banners_url}}"><img class="w-100" src="{{asset($home_banner[$no]->image->path)}}" alt=""></a>
@else
    <a href="#"><img class="w-100" src="{{asset($path_user.'img//home-banner-1.png').'?ver='.$ver}}" alt=""></a>
@endif
