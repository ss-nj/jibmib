<?php

namespace App\Http\Controllers;

use App\Http\Commerce\Models\Attribute;
use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Mail;
use App\Http\Commerce\Models\Place;
use App\Http\Core\Models\Banner\Banner;
use App\Http\Core\Models\City;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\Slider;
use App\Http\Shop\Models\Rate;
use App\Http\Shop\Models\Takhfif;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function citySelect(Request $request)
    {
        $city = $request->city;
//        dd($city);
        Place::where('slug', $city)->firstOrfail();
        Session::put('selected_city', $city);
        return redirect($city);
    }

    public function category($city, $category)
    {
        $city = $this->getCity($city);

        $category = Category::where('slug', $category)->firstOrfail();

        $takhfifs = Takhfif::
        whereHas('shop', function ($query) use ($city) {
            $query->where('place_id', $city->id);
        })->
        whereHas('categories', function ($query) use ($category) {
            $query->where('categories.id', $category->id);
        })->get();

        //get cat banners
        $banners = $this->getCatBanners();

        //get cat sliders
        $slides = $this->getSliders($city,$category->id);

        //find vip takhfifs
        $vip_takhfifs = $takhfifs->where('vip', '=', 1)->paginate(2);


        return view('front.category', compact('category', 'city', 'takhfifs', 'banners', 'slides', 'vip_takhfifs'));
    }

    /**
     * Show the application dashboard.
     * @param string $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $city = collect(request()->segments())->last();
        if ($city) {
            $city = $this->getCity($city);
        }

        //find banners
        $home_banner = $this->getHomeBanners($city);

        //find home categories
        $home_categories = $this->getHomeCats();

        //find vip takhfifs
        $vip_takhfifs = $this->getVipTakhfifs($city);

        //find cats under slider
        $categories = Category::inRandomOrder()->paginate(5);

        //get home sliders
        $slides = $this->getSliders($city);

        return view('front.home', compact('slides', 'categories',
            'home_categories', 'vip_takhfifs', 'home_banner'));
    }

    public function single($slug)
    {

        foreach (Takhfif::all() as $takhfif) {
            $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($takhfif->name));
            $takhfif->save();
        }

        $takhfif = Takhfif::with('shop', 'parameters', 'terms')->where('slug', $slug)->firstOrfail();
        $today_takhfifs = Takhfif::latest()->paginate(4);
        $similar_takhfifs = Takhfif::latest()->inRandomOrder()->paginate(4);

        $logos = Image::where('imagable_type', 'LOGOS')->get();
        $takhfif->view_count += 1;
        $takhfif->save();

//        Rate::updateOrCreate(['user_id' => rand(1,20), 'takhfif_id' => $takhfif->id]
//            , ['rate' => rand(1,5)]);

        $rates = Rate::where('takhfif_id', $takhfif->id)->get();
        $avg = round($rates->avg('rate'),1);
        $count = $rates->count();

        return view('front.single-takhfif', compact('takhfif', 'logos', 'today_takhfifs', 'similar_takhfifs','avg','count'));
    }

    public function policy()
    {
        $title = 'قوانین و مقررات';
        $content = Setting::where('key', 'policy')->first()->value_fa;

        return view('front.page', compact('content', 'title'));
    }

    public function aboutUs()
    {
        $title = 'درباره ما';
        $content = Setting::where('key', 'about_us_page')->first()->value_fa;

        return view('front.page', compact('content', 'title'));
    }

    public function contactUs()
    {
        $title = 'تماس با ما';
        $content = Setting::where('key', 'contact_us')->first()->value_fa;

        return view('front.page', compact('content', 'title'));
    }

    public function getCitiesByAjax(Request $request)
    {
        $cities = City::where('province_id', $request->province)->get();
        return response()->json(['cities' => $cities], 200);
    }

    /**
     * @param Request $request
     * @param string $type
     * @param [] $table
     * @param integer $position
     * @param integer $id
     * @return false|string
     */
    public function changePosition(Request $request)
    {
//        dd('exists:'.$request->table,);
        $request->validate([
            'type' => array('required', 'in:moveAfter,moveBefore'), // type of move, moveAfter or moveBefore
            'table' => ['required', 'string', 'in:places,categories,sliders,coupons,attributes'],
            'position' => 'exists:' . $request->table . ',id', // id of relative entity
            'id' => 'required|numeric|exists:' . $request->table // entity id
        ]);

        $table = $request->table;
        $model_id = $request->id;
        $type = $request->type;
        $position = $request->position;
        $sortableEntities = [
            'categories' => Category::class, //
            'places' => Place::class, //
            'banners' => Banner::class, //
            'sliders' => Slider::class, //
            'attributes' => Attribute::class, //
        ];
        $model = $sortableEntities[$table];
        $record = $model::find($model_id);
        $positionEntity = $model::find($position);
//dd($record,$positionEntity);
        if (!$record || !$positionEntity)
            return JsonResponse::sendJsonResponse(0, 'نا موفق', 'پیدا نشد لطفا دوباره تلاش کنید', 'REFRESH');

        try {
//            $record=   Slider::find(3);
//            $record->position=10;
//            $record->save();
//            $p=$record->position;
//            dd($record,$positionEntity);
            $record->$type($positionEntity);
//            $record->save();
//            dd($p,$p=$record->position  );
            return JsonResponse::sendJsonResponse(1, ' موفق', 'با موفقیت تفییر کرد', 'DATATABLE_REFRESH');

        } catch (\Exception $exception) {
            Log::alert($exception);
            return JsonResponse::sendJsonResponse(0, 'نا موفق', 'مشکلی پیش آمده دوباره تلاش کنید', 'REFRESH');
        }

    }

    public function join(Request $request)
    {

        $request->validate([
            'email_address' => ['required', 'string', 'email', 'max:255'],

        ]);
        Mail::create($request->all());

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت ذخیره شد');

    }

    /**
     * @param $city
     * @return array
     */
    public function getHomeBanners($city): array
    {
        $home_banner = [];
        $banner_map = [
            'FIRST_PAGE_1',
            'FIRST_PAGE_2',
            'FIRST_PAGE_3',
            'FIRST_PAGE_4',
            'FIRST_PAGE_5',
        ];
        foreach ($banner_map as $banner) {
            $bannerItem = Banner::where('banner_position', $banner)
                ->where('start_date', '<=', now())->where('expires_date', '>=', now());

            if ($city) $bannerItem = $bannerItem->where('place_id', $city->id);

            $home_banner[] = $bannerItem->first();
        }
        return $home_banner;
    }

    /**
     * @return array
     */
    public function getHomeCats(): array
    {
        $home_categories_map = [
            'home_category_1',
            'home_category_2',
            'home_category_3',
            'home_category_4',
            'home_category_5',
        ];
        $home_categories = [];
        foreach ($home_categories_map as $cat) {
            $home_categories[] = Category::with('takhfifs.shop')->find(Setting::where('key', $cat)->first()->value_fa);
        }
        return $home_categories;
    }

    /**
     * @param null $city
     * @return mixed
     */
    public function getVipTakhfifs( $city)
    {
        $vip_takhfifs = Takhfif::where('vip', '=', 1);

        if ($city) $vip_takhfifs = $vip_takhfifs->whereHas('shop', function ($query) use ($city) {
            $query->where('place_id', $city->id);
        });

        $vip_takhfifs = $vip_takhfifs->inRandomOrder()->paginate(2);
        return $vip_takhfifs;
    }

    /**
     * @param null $city
     * @param null $category_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSliders($city, $category_id=null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $slides = Slider::with('image');

        if ($city) $slides = $slides->where('place_id', $city->id);

        if ($category_id) $slides = $slides->where('category_id', $category_id);

        $slides = $slides->paginate(6);
        return $slides;
    }

    /**
     * @param $city
     * @return mixed
     */
    public function getCity($city)
    {
        $city = Place::where('slug', $city)->firstOrfail();
        Session::put('selected_city', $city->slug);
        return $city;
    }

    /**
     * @return array
     */
    public function getCatBanners(): array
    {
        $banners = [];
        $banner_map = [
            'CATEGORIES_1',
            'CATEGORIES_2',
            'CATEGORIES_3',
            'CATEGORIES_4',
        ];
        foreach ($banner_map as $banner) {
            $banners[] = Banner::where('banner_position', $banner)->where('start_date', '<=', now())->where('expires_date', '>=', now())->first();
        }
        return $banners;
    }

}
