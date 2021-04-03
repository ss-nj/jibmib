<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\ShopsDataTable;
use App\Http\Commerce\Models\Coupon;
use App\Http\Commerce\Models\Uploads;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//dd(1);
        $query = Shop::with('city', 'province', 'category', 'licence', 'userid', 'disapprove');
//        dd(Shop::find(1)->full_address);
//dd($query->first());

        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('shop_name', 'LIKE', '%' . $request->searchByName . '%');
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


        $datatable = new ShopsDataTable($query);

        return $datatable->render('panel.shops.index');
    }

    public function activeToggle(Request $request, Shop $shop)
    {

//        if (!Auth::user()->can('delete-coupon')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $shop->active = !$shop->active;
        $shop->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $shop->active]);
        return back();
    }

    public function approve(Request $request, Uploads $upload)
    {
//        dd($request->all());
        $request->validate([
            'reason' => ['required_if:approve,0', 'string', 'max:80'],
            'approve' => ['required', 'in:0,1'],

        ]);
        $upload->reason = $request->reason;
        $upload->approved = $request->approve;
        $upload->save();

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت ثبت شد',
            'DATATABLE_REFRESH');
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


        $shop = Shop::create($request->all());
        $shop->slug = sprintf('%s-%s', $shop->id, str_slug_persian($shop->shop_name));
        $shop->save();
        try {
            //save current path for ramove
            $this->saveImage($shop, $request);

        } catch (\Exception $e) {
            Log::info($e);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('ویژگی  %s  با موفقیت ایجاد گردید', $shop->shop_name),
            'DATATABLE_REFRESH');

    }

    public function update(Request $request, Shop $shop)
    {
        $shop = Shop::findOrfail($shop);
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
            ح]);

        $shop->update($request->all());
//
        $shop->slug = sprintf('%s-%s', $shop->id, str_slug_persian($shop->shop_name));
        $shop->save();
        try {
            //save current path for ramove
            $this->saveImage($shop, $request);

        } catch (\Exception $e) {
            Log::info($e);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('پروفایل  %s  با موفقیت ویرایش شد', $shop->name),
            'REDIRECT', route('shops.index'));
    }


    public function edit(Shop $shop)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }


        return view('panel.shop.edit', compact('shop'));
    }

    /**
     * @param $shop
     * @param Request $request
     */
    public function saveImage($shop, Request $request): void
    {
        $path = $shop->logo->path;
        $file = $request->file('main_image');
        if ($file) {
            $extention = '.' . $file->getClientOriginalExtension();
            $imageName = uniqid() . md5($file->getClientOriginalName()) . $extention;
            //save file to folder

            $imgaddress = $file->move('img/shop/profile/' . $shop->id, $imageName)->getpathname();
            $shop->logo()->updateOrCreate([], [
                'path' => $imgaddress,
                'thumbnail' => '',
                'title' => $shop->shop_name
            ]);
            Image::removeImage($path);
        }
    }

    public function approveShop(Request $request, Shop $shop)
    {
//dd($request->all());
        $request->validate([
            'reason' => ['required_if:approve,0', 'string', 'max:80'],
            'approve' => ['required', 'in:0,1'],

        ]);

        $shop->approved = $request->approve;
        $shop->save();

        if ($request->approve == 0) {
            $shop->disapproves()->create([
                'reason' => $request->reason,
            ]);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت ثبت شد',
            'DATATABLE_REFRESH');
    }

}
