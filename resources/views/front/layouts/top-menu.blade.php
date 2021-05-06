{{--{{dd(Route::currentRouteName())}}--}}
<div class="col-10">
    <nav class="navbar primary-nav-container">
        <ul class="nav">
            <li class="nav-item">
                <a href="#" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fa-regular fa-bars"></i></span> دسته بندی</a>
                <div class="dropdown-menu">
                    @foreach($cached_categories->whereNull('category_id') as  $cached_category)
                    <div class="dropdown-item pt-3 menu-dropright">
                        <div class="d-flex justify-content-between">
                            @if($cached_category->icon)
                                <div><i class="fa-regular {{$cached_category->icon}}"></i></div>
                            @else
                                <div><i class="fa-regular fa-turkey"></i></div>
                            @endif
                            <div class="align-self-center">
                                <a  style="font-weight: 400;font-size: 1.1rem" href="{{route('category',['city'=>$selected_city,'cat'=>$cached_category->slug])}}">
                                {{$cached_category->name}}
                            </a></div>
                            <div class="align-self-center"><i class="fa-regular fa-angle-left"></i></div>

                        </div>
                        @if($cached_category->categories_count >0)
                        <div class="sub-menu" style="display: none;">
                            @foreach($cached_category->categories as $category)
                                <a href="{{route('category',['city'=>$selected_city,'cat'=>$category->slug])}}">
                                    <div class="dropdown-item w-100 pt-3 pl-2">{{$category->name}}</div>
                                </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </li>

            @foreach($cashed_menus->where('menu','header') as $cashed_menu)
                <li class="nav-item "><a href="{{$cashed_menu->link}}">{{$cashed_menu->name}}</a></li>
            @endforeach
        </ul>
    </nav><!--.d-flex-->
</div>

