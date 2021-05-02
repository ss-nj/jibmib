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
        $this->shop->takhfifs;
        $this->shop->takhfifs->count();
        $this->shop->wallet;
        $this->shop->orders;
        $this->shop->orders->count();
        $this->shop->orders->sum('takhfif_discount');
        $this->shop->refunds;
        $this->shop->refunds->sum('amount');
        return view('shop.dashboard.dashboard',['shop'=>$this->shop]);
    }
}
