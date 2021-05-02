<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopDashboardController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $shop;

    public function __construct()
    {
//        $this->shop = Auth::user();
        $this->shop = Shop::find(1);
    }

    public function index()
    {

        //takhfifs
        //sells
        //income
        //wallet
        //refunds
        $takhfifs = $this->shop->takhfifs;
        $takhfifs_count = $this->shop->takhfifs->count();
        $wallet = $this->shop->wallet->amount;
        $orders = $this->shop->orders;
        $orders_count = $this->shop->orders->count();
        $orders_sum = $this->shop->orders->sum('takhfif_discount');
        $refunds_count = $this->shop->refunds->count();
        $refunds_approved_count = $this->shop->approvedRefunds->count();
        $refunds_approved_sum = $this->shop->approvedRefunds->sum('amount');
        return view('shop.dashboard.dashboard', compact(
            'takhfifs', 'takhfifs_count',
            'refunds_count', 'refunds_approved_sum', 'refunds_approved_count', 'wallet',
            'orders', 'orders_count', 'orders_sum',
        ));
    }
}
