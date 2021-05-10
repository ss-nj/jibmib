<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Phone;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PhoneController extends Controller
{


    public function index(Shop $shop)
    {

        if ($shop->id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $phones = Phone::where('shop_id', $shop->id)->get();
        return response()->json(['phones' => $phones], 200);
    }

    public function store(Request $request, Shop $shop)
    {
        if ($shop->id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $request->validate([
            'number' => ['required','digits_between:4,11'],// 'unique:phones,number,' . auth()->id()
        ]);

        if ($shop->phones()->count() >= 5)
            return response()->json(['data' => ['success' => false, 'message' => 'حداکثر 5 شماره قابل ثبت است']]);

       $phone= $shop->phones()->create($request->all());

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت ثبت شد','phone_id'=>$phone->id,'phone_number'=>$phone->number]]);


    }


    public function update(Request $request, Phone $phone)
    {

        if ($phone->shop_id != Auth::guard('shop')->id())
            return response()->json(['data' => ['success' => false, 'message' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']]);


        $request->validate([
            'number' => ['required','digits_between:6,11'],// 'unique:phones,number,' . auth()->id()
        ]);

        $phone->update($request->all());
        return response()->json(['data' => ['success' => true, 'message' => 'شماره تلفن با موفقیت روز رسانی گردید']]);

    }

    public function destroy(Phone $phone)
    {
        if ($phone->shop_id != Auth::guard('shop')->id())
            return response()->json(['data' => ['success' => false, 'message' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']]);

        $phone->delete();
        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }

}
