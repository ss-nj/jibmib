<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopDashboardController extends Controller
{

    public function index()
    {

        $shop = Auth::guard('shop')->user();
//        $shop = Shop::find(1);

        $takhfifs = $shop->takhfifs;
        $takhfifs_count = $shop->takhfifs->count();
        $wallet = $shop->wallet?$shop->wallet->amount:0;
        $orders = $shop->orders;
        $orders_count = $shop->orders->count();
        $orders_sum = $shop->orders->sum('takhfif_discount');
        $refunds_count = $shop->refunds->count();
        $refunds_approved_count = $shop->approvedRefunds->count();
        $refunds_approved_sum = $shop->approvedRefunds->sum('amount');


        $orders = $shop->orders->where('created_at', '>', now()->subYear())->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y m d'); // grouping by day
        });

        $chart = [];
        $i = 0;

        foreach ($orders as $key => $day) {

            $changed = $day->sum('takhfif_discount');

            if (!$changed)
                continue;

            $chart['label'][$i] = verta($day[0]->created_at)->format('Y/m/d');
            $chart['y'][$i] = $changed;

            $i++;
        }

        return view('shop.dashboard.dashboard', compact(
            'takhfifs', 'takhfifs_count',
            'refunds_count', 'refunds_approved_sum', 'refunds_approved_count', 'wallet',
            'orders', 'orders_count', 'orders_sum',
            'chart'
        ));
    }
}
