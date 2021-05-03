<?php

namespace App\Http\Shop\Controllers;
use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Takhfif;
use App\Http\Shop\Models\UsageTerm;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsageTermController extends Controller
{
    public function __construct()
    {

    }

    public function index(Takhfif $takhfif)
    {
        if ($takhfif->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $terms = UsageTerm::where('takhfif_id', $takhfif)->get();
        return response()->json(['terms' => $terms], 200);
    }

    public function store(Request $request, Takhfif $takhfif)
    {
        if ($takhfif->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $request->validate([
            'value' => ['required', 'string','max:999'],

        ]);

        $addTerm = $takhfif->terms()->create($request->all());


        return JsonResponse::sendJsonResponse(1, 'موفق', 'ویژگی با موفقیت ثبت گردید',
            '', '',
            'addTerm', [$addTerm->id, $addTerm->value,
            ]);

    }


    public function destroy(UsageTerm $usage_term)
    {
        if ($usage_term->takhfif->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $usage_term->delete();

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }
}
