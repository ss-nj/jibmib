<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Phone;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhoneController extends Controller
{
    public function __construct()
    {
        //todo check auth

    }

    public function index(Shop $shop)
    {
        $phones = Phone::where('shop_id', $shop)->get();
        return response()->json(['phones' => $phones], 200);
    }

    public function store(Request $request, Shop $shop)
    {
//        dd($request->all());
//        if (!Auth::user()->can('read-phone')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'number' => ['required','digits_between:4,11'],// 'unique:phones,number,' . auth()->id()
        ]);

        if ($shop->phones()->count() >= 5)
            return response()->json(['data' => ['success' => false, 'message' => 'حداکثر 5 شماره قابل ثبت است']]);

       $phone= $shop->phones()->create($request->all());

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت ثبت شد','phone_id'=>$phone->id,'phone_number'=>$phone->number]]);

//        return JsonResponse::sendJsonResponse(1, 'موفق', 'شماره تلفن با موفقیت ثبت گردید',
//            'DATATABLE_REFRESH');

    }


    public function update(Request $request, Phone $phone)
    {
//        if (!Auth::user()->can('update-phone')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'number' => ['required','digits_between:6,11'],// 'unique:phones,number,' . auth()->id()
        ]);

        $phone->update($request->all());
        return response()->json(['data' => ['success' => true, 'message' => 'شماره تلفن با موفقیت روز رسانی گردید']]);

    }

    public function destroy(Phone $phone)
    {
//        if (!Auth::user()->can('delete-phone')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $phone->delete();
        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }

}
