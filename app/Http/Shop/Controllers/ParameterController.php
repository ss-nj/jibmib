<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Parameter;
use App\Http\Shop\Models\Takhfif;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParameterController extends Controller
{
    public function __construct()
    {
        //todo check auth

    }

    public function index(Takhfif $takhfif)
    {
        $parameters = Parameter::where('takhfif_id', $takhfif)->get();
        return response()->json(['parameters' => $parameters], 200);
    }

    public function store(Request $request, Takhfif $takhfif)
    {
        if ($takhfif->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $request->validate([
            'value' => ['required', 'string','max:999'],

        ]);

        $parameter = $takhfif->parameters()->create($request->all());


        return JsonResponse::sendJsonResponse(1, 'موفق', 'ویژگی با موفقیت ثبت گردید',
            'DATATABLE_REFRESH', '',
            'addParameter', [$parameter->id, $parameter->value,
            ]);

    }


    public function destroy(Parameter $parameter)
    {
        if ($parameter->takhfif->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);


        $parameter->delete();

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }
}
