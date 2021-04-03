<?php

namespace App\Http\Core\Controllers;

use App\DataTables\BannerDataTable;
use App\Http\Core\Models\Banner\Banner;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\Image;
use App\Support\JsonResponse;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-banner')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//dd(1);


        $start_time = null;
        $end_time = null;
        if ($request->searchByStartTime !== null && $request->has('searchByStartTime')) {
            $start_time = fa_to_en($request->searchByStartTime);
            $start_time = explode('-', $start_time);
            $time = $start_time[3];
            $start_time = Verta::getGregorian($start_time[0], $start_time[1], $start_time[2]);
            $start_time = implode('-', $start_time);
            $start_time = $start_time . ' ' . $time;
        }

        if ($request->searchByEndTime !== null && $request->has('searchByEndTime')) {
            $end_time = fa_to_en($request->searchByEndTime);
            $end_time = explode('-', $end_time);
            $time = $end_time[3];
            $end_time = Verta::getGregorian($end_time[0], $end_time[1], $end_time[2]);
            $end_time = implode('-', $end_time);
            $end_time = $end_time . ' ' . $time;

        }

        $query = Banner::with('image');


        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('title', 'LIKE', '%' . $request->searchByName . '%');
        }

        if ($request->searchByCategory) {
            $query->where('category_id',   $request->searchByCategory );

        }
        if ($request->searchByPlace) {
            $query->where('place_id',   $request->searchByPlace );
        }

//dd($start_time,$end_time);
        if ($start_time) {
            $query->where('start_date','>=', $start_time);
        }

        if ($end_time) {
            $query->where('expires_date','<=', $end_time);
        }

        if ($request->searchByPosition) {
            $query->where('banner_position',   $request->searchByPosition );
        }

        if ($request->searchByAscDesc) {
            $ascDesc = $request->searchByAscDesc;

        } else {
            $ascDesc = 'DESC';
        }

        if ($request->searchSortBy) {
            $searchSortBy = $request->searchSortBy;
            if ($ascDesc == 'DESC')
                $query->latest($searchSortBy);
            else
                $query->oldest($searchSortBy);

        } else
            $query->latest('created_at');


        $datatable = new BannerDataTable($query);

        return $datatable->render('panel.banner.index');
    }

    public function create()
    {

        return view('panel.banner.banner-create');
    }

    public function store(Request $request)
    {
//        if (!Auth::user()->can('read-banner')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }


        $this->bannerValidator($request);
        $this->persianTimeStampToGregorian($request);

        $banner = Banner::create($request->all());
//        dd($request->all());
        $file = $request->file('main_image');
        if ($file) {
            $name = time() . $file->getClientOriginalName();
            $dir = 'img/banner/' . $banner->id;
            $file->move($dir, $name);
            $banner->image()->create([
                'path' => $dir . '/' . $name,
                'thumbnail' => '',
                'title' => $banner->name
            ]);
        }


        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('بنر  %s  با موفقیت ایجاد گردید', $banner->name),
            'REDIRECT', route('banner.index'));

    }


    public function update(Request $request, Banner $banner)
    {
//        if (!Auth::user()->can('update-banner')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $this->bannerValidator($request);

        $this->persianTimeStampToGregorian($request);

        $banner->update($request->all());
        $file = $request->file('main_image');
        if ($file) {

            $name = time() . $file->getClientOriginalName();
            $dir = 'img/banner/' . $banner->id;
            $file->move($dir, $name);
            $path = $banner->image->path;
            $thumbnail = $banner->image->thumbnail;

            if ($path && $path !== Image::NO_IMAGE_PATH) {
                $banner->image()->delete();
                Image::removeImage($path);
                if ($thumbnail) Image::removeImage($thumbnail);
            }
            $banner->image()->create([
                'path' => $dir . '/' . $name,
                'thumbnail' => '',
                'title' => $banner->name
            ]);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('بنر  %s  با موفقیت روز رسانی گردید', $banner->name),
            'REDIRECT', route('banner.index'));

    }

    public function destroy(Banner $banner)
    {
//        if (!Auth::user()->can('delete-banner')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        //check if has product or items

           $banner->delete();

        return back()->with('message', sprintf('بنر  %s  با موفقیت حذف گردید', $banner->name));

    }

    /**
     * @param Request $request
     */
    public function bannerValidator(Request $request): void
    {

        $start_time = fa_to_en($request->start_date);
        $end_time = fa_to_en($request->expires_date);
        $request->merge([
            'expires_date' => $end_time,
            'start_date' => $start_time,
        ]);
        if ($request->main_image == 'undefined')
            $request->offsetUnset('main_image');
//        dd(($request->all()));
        $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'place_id' => ['nullable', 'integer', 'exists:places,id'],
            'banner_position' => ['required',  'in:'.implode(',',array_keys(Banner::BANNER_MAP))],
            'title' => 'required|string|min:2|max:50',
            'banners_url' => 'required|string|min:2|max:100',
            'start_date' => 'required|jdatetime:Y-m-d-H:i:s',
            'expires_date' => 'required|jdatetime:Y-m-d-H:i:s',
            'active' => 'integer',
            'main_image' => ($request->_method == 'put' ? 'nullable|' : 'required|') . 'image|mimes:jpg,jpeg,png,svg',

        ]);
    }

    /**
     * @param Request $request
     */
    public function persianTimeStampToGregorian(Request $request): void
    {
            $start_time = fa_to_en($request->start_date);
            $start_time = explode('-', $start_time);
            $time = $start_time[3];
            $start_time = Verta::getGregorian($start_time[0], $start_time[1], $start_time[2]);
            $start_time = implode('-', $start_time);
            $start_time = $start_time . ' ' . $time;


            $end_time = fa_to_en($request->expires_date);
            $end_time = explode('-', $end_time);
            $time = $end_time[3];
            $end_time = Verta::getGregorian($end_time[0], $end_time[1], $end_time[2]);
            $end_time = implode('-', $end_time);
            $end_time = $end_time . ' ' . $time;

//dd($start_time,$end_time);
        $request->merge([
            'start_date' => $start_time,
            'expires_date' => $end_time,
        ]);
    }

    public function activeToggle(Request $request, Banner $banner)
    {
//        dd($banner);
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $banner->active = !$banner->active;
        $banner->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $banner->active]);

        return back();
    }

    public function edit(Banner $banner)
    {
        return view('panel.banner.banner-edit', compact('banner'));
    }


}
