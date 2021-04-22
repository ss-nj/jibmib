<?php

namespace App\Http;

use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Rate;
use App\Http\Shop\Models\Takhfif;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function rate(Request $request)
    {

        $request->validate([
            'rate' => 'required|numeric',
            'slug' => 'exists:takhfifs,slug',
        ]);

        $userId = Auth::id();
        $rate = $request->rate;
        $slug = $request->slug;
        $takhfif = Takhfif::whereSlug($slug)->first();


        Rate::updateOrCreate(['user_id' => $userId, 'takhfif_id' => $takhfif->id]
            , ['rate' => $rate]);

        $rates = Rate::where('takhfif_id', $takhfif->id)->get();
        $avg = round($rates->avg('rate'),1);
        $count = $rates->count();

        return JsonResponse::sendJsonResponse(1, 'موفق',
            'با موفقیت ثبت شد', '', '',
            'changeRate', [$avg,$count]);

    }


}
