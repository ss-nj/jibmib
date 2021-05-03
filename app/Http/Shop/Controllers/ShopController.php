<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShopController extends Controller
{
    /**
     * @param $shop
     * @return array
     */
    public function setDefaultOption($shop): array
    {
        $defaultOption = [
            'size' => ['width' => 600, 'height' => 400],
            'watermark' => true,
            'changesize' => true,
            'dir' => 'img/shop/' . $shop->id
        ];
        return $defaultOption;
    }

    public function index()
    {
        $shop = Auth::guard('shop')->user();
        $phones = $shop->phones;
        $times = $shop->times;
        return view('shop.profile.profile', compact('shop', 'phones', 'times'));
    }

    public function update(Request $request, $profiles)
    {
        $shop = Shop::findOrfail($profiles);
        if ($request->main_image == 'undefined')
            $request->offsetUnset('main_image');
//        dd($request->all());
        $request->validate([
            'owner_name' => ['string', 'max:80'],
            'shop_name' => ['required', 'string', 'max:80'],
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

        $shop->update($request->all());
//
        $shop->slug = sprintf('%s-%s', $shop->id, str_slug_persian($shop->shop_name));
        $shop->save();
        try {
            //save curent path for ramove
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

        } catch (\Exception $e) {
            Log::info($e);
        }

        if ($shop->lat && $shop->lang) {
            $path = public_path('img/shops/' . $shop->id . '/maps/');

            if (!File::isDirectory($path)) {

                File::makeDirectory($path, 0777, true, true);
            }
            $map_url = sprintf('http://www.google.com/maps/place/%s,%s/@%s,%s,10z', $shop->lat, $shop->lang, $shop->lat, $shop->lang);

            QrCode::size(150)->generate($map_url, 'img/shops/' . $shop->id . '/maps/map.svg');

        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('پروفایل  %s  با موفقیت ویرایش شد', $shop->shop_name),
            'REFRESH');
    }

    public function loadImages(Shop $shop)
    {
        if ($shop->id !== Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        return $shop->images;
    }

    public function uploadImages(Request $request, Shop $shop)
    {

        if ($shop->id !== Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);
//todo set it in settings
//        if ($shop->images->count() >= 5)
//            return response('حداکثر تعداد فایل اپلودی رد شده است .', 400);

        $image = $this->ajaxSaveImage($request, $shop);

        return $image->id;
    }

    public function destroyImage(Image $image)
    {
        if ($image->imagable_id !== Auth::guard('shop')->id())
            return response()->json(['success' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']);

        $path = $image->path;
        $thumbnail = $image->thumbnail;
        $image->delete();
        //remove the image file
        try {
            if ($path) Image::removeImage($path);
            if ($thumbnail) Image::removeImage($thumbnail);
        } catch (\Exception $exception) {
            Log::info($exception);
        }

        return response()->json(['success' => 'با موفقیت حذف شد .']);

    }

    /**
     * @param Request $request
     * @param $shop
     * @return
     */
    public function ajaxSaveImage(Request $request, $shop)
    {
        $imageName = null;
        //set default option
        $defaultOption = $this->setDefaultOption($shop);
        if ($request->hasFile('main_image')) {

            try {
                $upload = upload_image($request->file('main_image'), $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
                return $shop->images()->create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'title' => $shop->shop_name
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }
    }


    //licences methods

    public function loadLicences(Shop $shop)
    {

        if ($shop->id !== Auth::guard('shop')->id())
            return response()->json(['success' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']);

        return $shop->licences;
    }

    public function uploadLicences(Request $request, Shop $shop)
    {
        if ($shop->id !== Auth::guard('shop')->id())
            return response()->json(['success' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']);
//todo set it in settings
//        if ($shop->images->count() >= 5)
//            return response('حداکثر تعداد فایل اپلودی رد شده است .', 400);

        $image = $this->ajaxSaveLicence($request, $shop);

        return $image->id;
    }

    public function destroyLicence(Image $image)
    {
        if ($image->imagable_id !== Auth::guard('shop')->id())
            return response()->json(['success' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']);
        $path = $image->path;
        $thumbnail = $image->thumbnail;
        $image->delete();
        //remove the image file
        try {
            if ($path) Image::removeImage($path);
            if ($thumbnail) Image::removeImage($thumbnail);
        } catch (\Exception $exception) {
            Log::info($exception);
        }

        return response()->json(['success' => 'با موفقیت حذف شد .']);

    }

    /**
     * @param Request $request
     * @param $shop
     * @return
     */
    public function ajaxSaveLicence(Request $request, $shop)
    {
        $imageName = null;
        //set default option
        $defaultOption = [
            'size' => ['width' => 600, 'height' => 400],
            'watermark' => true,
            'changesize' => true,
            'dir' => 'img/shop/licences' . $shop->id
        ];
        if ($request->hasFile('main_image')) {

            try {
                $upload = upload_image($request->file('main_image'), $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
                return $shop->licences()->create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'title' => $shop->shop_name
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }
    }
}
