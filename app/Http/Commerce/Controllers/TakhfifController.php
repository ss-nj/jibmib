<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\TakhfifsDataTable;
use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Takhfif;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TakhfifController extends Controller
{
    public function ajaxTakhfifList(Request $request)
    {

        $data = $data = DB::table("takhfifs")
            ->select("id", "title")
            ->where('active', 1)
            ->limit(20)
            ->get();;


        if ($request->has('q')) {
            $search = $request->q;
            $data = DB::table("takhfifs")
                ->select("id", "title")
                ->where('active', 1)
                ->where('title', 'LIKE', "%$search%")
                ->limit(15)
                ->get();
        }


        return response()->json($data);

    }
    public function ajaxCategoriesList(Request $request)
    {

        $data = $data = DB::table("categories")
            ->select("id", "name")
            ->where('active', 1)
            ->limit(20)
            ->get();;


        if ($request->has('q')) {
            $search = $request->q;
            $data = DB::table("categories")
                ->select("id", "name")
                ->where('active', 1)
                ->where('name', 'LIKE', "%$search%")
                ->limit(15)
                ->get();
        }


        return response()->json($data);

    }

    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//dd(1);
        $query = Takhfif::with('shop', 'images', 'categories','disapprove');
//        dd(Takhfif::find(1)->full_address);
//dd($query->first());

        if ($request->searchById) {
            $query->where('id', $request->searchById);
        }

        if ($request->searchByName) {
            $query->where('name', 'LIKE', '%' . $request->searchByName . '%');
        }
        if ($request->searchBySlug) {
            $query->where('slug', 'LIKE', '%' . $request->searchBySlug . '%');
        }

        if ($request->searchByCity) {
            $query->whereHas('city', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchByCity . '%');
            });
        }
        if (isset($request->searchByStatus)) {
            $query->where('approved', $request->searchByStatus);
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


        $datatable = new TakhfifsDataTable($query);

        return $datatable->render('panel.takhfifs.index');
    }

    public function activeToggle(Request $request, Takhfif $takhfif)
    {

//        if (!Auth::user()->can('delete-coupon')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $takhfif->active = !$takhfif->active;
        $takhfif->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $takhfif->active]);
        return back();
    }


    public function store(Request $request)
    {
        if ($request->main_image == 'undefined')
            $request->offsetUnset('main_image');
        $request->validate([
            'owner_name' => ['string', 'max:80'],
            'shop_name' => ['string', 'max:80'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'lat' => ['required', 'max:20'],
            'lang' => ['required', 'max:20'],
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:999'],
            'place_id' => ['required', 'integer', 'exists:places,id'],
            'description' => ['required', 'string', 'max:5000'],
            'uuid' => ['required', 'integer', 'digits:10'],
            'isbn' => ['required', 'string', 'max:30'],
            'bank_id' => ['required', 'string', 'max:20'],
            'bank_account_owner_name' => ['required', 'string', 'max:80'],
            'bank_account_owner_last_name' => ['required', 'string', 'max:80'],
            'bank_account_type' => ['required', 'string', 'max:80'],
            'main_image' => ['image', 'mimes:jpg,jpeg,png,svg'],
        ]);


        $takhfif = Takhfif::create($request->all());
        $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($takhfif->shop_name));
        $takhfif->save();
        try {
            //save current path for ramove
            $this->saveImage($takhfif, $request);

        } catch (\Exception $e) {
            Log::info($e);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('ویژگی  %s  با موفقیت ایجاد گردید', $takhfif->shop_name),
            'DATATABLE_REFRESH');

    }

    public function update(Request $request, Takhfif $takhfif)
    {
        $takhfif = Takhfif::findOrfail($takhfif);
        if ($request->main_image == 'undefined')
            $request->offsetUnset('main_image');
        $request->validate([
            'owner_name' => ['string', 'max:80'],
            'shop_name' => ['string', 'max:80'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'lat' => ['required', 'max:20'],
            'lang' => ['required', 'max:20'],
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:999'],
            'place_id' => ['required', 'integer', 'exists:places,id'],
            'description' => ['required', 'string', 'max:5000'],
            'uuid' => ['required', 'integer', 'digits:11'],
            'isbn' => ['required', 'string', 'max:30'],
            'bank_id' => ['required', 'string', 'max:20'],
            'bank_account_owner_name' => ['required', 'string', 'max:80'],
            'bank_account_owner_last_name' => ['required', 'string', 'max:80'],
            'bank_account_type' => ['required', 'string', 'max:80'],
            'main_image' => ['image', 'mimes:jpg,jpeg,png,svg'],
            ]);

        $takhfif->update($request->all());
//
        $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($takhfif->shop_name));
        $takhfif->save();
        try {
            //save current path for ramove
            $this->saveImage($takhfif, $request);

        } catch (\Exception $e) {
            Log::info($e);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('پروفایل  %s  با موفقیت ویرایش شد', $takhfif->name),
            'REDIRECT', route('shops.index'));
    }


    public function edit(Takhfif $takhfif)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }


        return view('panel.shop.edit', compact('shop'));
    }

    /**
     * @param $takhfif
     * @param Request $request
     */
    public function saveImage($takhfif, Request $request): void
    {
        $path = $takhfif->logo->path;
        $file = $request->file('main_image');
        if ($file) {
            $extention = '.' . $file->getClientOriginalExtension();
            $imageName = uniqid() . md5($file->getClientOriginalName()) . $extention;
            //save file to folder

            $imgaddress = $file->move('img/shop/profile/' . $takhfif->id, $imageName)->getpathname();
            $takhfif->logo()->updateOrCreate([], [
                'path' => $imgaddress,
                'thumbnail' => '',
                'title' => $takhfif->shop_name
            ]);
            Image::removeImage($path);
        }
    }

    public function approveTakhfif(Request $request, Takhfif $takhfif)
    {
//dd($request->all());
        $request->validate([
            'reason' => ['required_if:approve,0', 'string', 'max:80'],
            'approve' => ['required', 'in:0,1'],

        ]);

        $takhfif->approved = $request->approve;
        $takhfif->save();

        if ($request->approve == 0) {
            $takhfif->disapproves()->create([
                'reason' => $request->reason,
            ]);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت ثبت شد',
            'DATATABLE_REFRESH');
    }
}
