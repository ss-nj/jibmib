<?php

namespace App\Http\Shop\Controllers;

use App\Http\Commerce\Models\Coupon;
use App\Http\Controllers\Controller;

use App\OrderItem;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    public function index()
    {

        $id = auth()->id();
        $coupons = OrderItem::whereHas('takhfif',function ($query) use($id){
            $query->where('shop_id', $id);
        })->get();

        return view('shop.coupons.index', compact('coupons'));

    }
}
