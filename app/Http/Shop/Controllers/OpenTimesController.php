<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Shop\Models\OpenTimes;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpenTimesController extends Controller
{
    public function __construct()
    {
        //todo check auth

    }

    public function index(Shop $shop)
    {
        $openTimes = OpenTimes::where('shop_id', Auth::guard('shop')->id())->get();
        return response()->json(['times' => $openTimes], 200);
    }

    public function store(Request $request, Shop $shop)
    {

        if ($shop->id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        $request->validate([
            'time' => ['required','array'],// 'unique:times,number,' . auth()->id()
            'time.*' => ['required','digits_between:0,59'],// 'unique:times,number,' . auth()->id()
            'days' => ['required','array'],// 'unique:times,number,' . auth()->id()
            'days.*' => ['required','digits_between:0,8'],// 'unique:times,number,' . auth()->id()
        ]);

        $time = $shop->times()->create([
            'start_time' => Carbon::createFromTime($request->time[0], $request->time[1]),
            'end_time' => Carbon::createFromTime($request->time[2], $request->time[3]),
            'week_day' => serialize($request->days),
        ]);
//addTime(Id, day, start_time, end_time)
        $week_day_map = [
            1 => 'شنبه',
            2 => 'یکشنبه',
            3 => 'دوشنبه',
            4 => 'سه شنبه',
            5 => 'چهارشنبه',
            6 => 'پنج شنبه',
            7 => 'جمعه',
            8 => 'روزهای تعطیل',

        ];
        $days = '';
        foreach (unserialize($time->week_day) as $day)
            $days .=  $week_day_map[$day].'-';

        return JsonResponse::sendJsonResponse(1, 'موفق', 'زمان با موفقیت ثبت گردید',
            'DATATABLE_REFRESH', '',
            'addTime', [$time->id, $days,
                verta($time->start_time)->timezone('Asia/Tehran')->format('H:i'),
                verta($time->end_time  )->timezone('Asia/Tehran')->format('H:i'),
            ]);

    }


    public function destroy(OpenTimes $openTimes)
    {

        if ($openTimes->shop_id != Auth::guard('shop')->id())
            return response()->json(['data' => ['success' => false, 'message' => 'کد وارد شده متعلق به فروشگاه شما نیست !!']]);

        $openTimes->delete();

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }
}
