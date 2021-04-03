<?php

namespace App\Http\View\Composers;

use App\Basket;
use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Place;
use App\Http\Core\Models\City;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Menu;
use App\Http\Core\Models\Province;
use App\Http\Core\Models\Setting;
use App\Http\Shop\Models\Takhfif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SharedDataComposer
{


    /**
     * Create a new composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...

    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * //     * @return void
     */
    public function compose(View $view)
    {

        $siteSettings = Cache::remember('siteSettings', '10', function () {
            return Setting::select('key', 'label', 'value_en', 'value_fa', 'type')
                ->get()
                ->keyBy('key');
        });

        $cached_cities = Cache::remember('cached_cities', '10', function () {
            return City::orderBy('name', 'asc')->get();

        });

        $cached_provinces = Cache::remember('cached_provinces', '10', function () {
            return Province::orderBy('name', 'asc')->get();

        });

        $cached_places = Cache::remember('cached_places', '10', function () {
            return Place::orderBy('name', 'asc')->get();

        });

        $cached_categories = Cache::remember('cached_categories', '10', function () {
            return Category::with('categories')->withCount('categories')->orderBy('name', 'asc')->get();

        });

        $cashed_menus = Cache::remember('cashed_menus', '10', function () {
            return Menu::orderBy('position', 'asc')->get();

        });

        $logos = Cache::remember('cashed_logos', '10', function () {
            return Image::where('imagable_type', 'LOGOS')->get();

        });

        $selected_city = Session::get('selected_city', 'isfahan');


        if (auth()->check()) {
            $baskets = \auth()->user()->baskets;
            $cart_count = Basket::where('user_id', Auth::id())->count();
            $cart_sum = Basket::where('user_id', auth()->id())->sum('discount_price');
        } else {
            $cart_count = 0;
            $cart_sum = 0;
            $baskets = [];
        }

        $path = url('/') . '/thems/jibmib/';
        $path_user = url('/') . '/thems/jibmib-user/';
        $ver = '.01';
        $view->with(compact('siteSettings', 'path', 'path_user', 'ver', 'logos', 'selected_city',
            'cart_count', 'cart_sum','baskets',
            'cached_cities', 'cached_provinces', 'cached_places', 'cached_categories',
            'cashed_menus'));

    }
}
