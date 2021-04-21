<div class="home-cat-section position-relative p-1">
    <img class="home-cat-img home-top-cat-img"
         src="{{asset($path_user.'img/top-cat.svg').'?ver='.$ver}}" alt="">
    <img class="home-cat-img home-bottom-cat-img"
         src="{{asset($path_user.'img/top-cat.svg').'?ver='.$ver}}" alt="">
    <ul class="side-cat">
        @foreach($cached_categories->whereNull('category_id') as  $cached_category)
            <li>
                <a href="{{route('category',['city'=>$selected_city,'cat'=>$cached_category->slug])}}">
                    @if($cached_category->icon)
                        <span><i class="{{$cached_category->icon}}" style="float: right"></i></span>
                    @else
                        <span><img src="{{asset($path_user.'img/cat-icon-1.svg').'?ver='.$ver}}" alt=""></span>
                    @endif
                    <span>{{$cached_category->name}}</span>
                    <span><i class="fa-regular fa-angle-left"></i></span>
                </a>
            </li>
        @endforeach
    </ul>

</div><!--home-cat-section-->

