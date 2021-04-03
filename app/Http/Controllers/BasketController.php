<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Support\BasketHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function cartView(Request $request)
    {
        //cart
        //total price
        //total sum
        //total discount
        if (Auth::check()) {
            BasketHelpers::setSessionCartToDatabase();
        }


        list($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount) = BasketHelpers::calcPrices();


        return view('front.basket',
            compact('baskets', 'totalPrice', 'total_count', 'totalPrice_no_dis', 'total_discount'));
    }


    public function change_count(Request $request)
    {

        $request->validate([
            'count' => ['required','digits_between:1,999'],
            'id' => ['required']
        ]);

        $count = $request->count;
        $basket = Basket::with('takhfif')->where('user_id', auth()->id())->find($request->id);
        if (!$basket ||$count<=0)
            return response()->json(['success' => false
                , 'error' => 'محصول قبلا از سبد حذف شده صفحه را رفرش(بارگزاری مجدد) کنید '], 200);


        if ($count > ($basket->takhfif->capacity + $basket->count)) {
            $error = sprintf('موجودی تنها  %s میباشد ', $basket->takhfif->capacity);
            return response()->json(['success' => false
                , 'error' => $error], 200);
        }

        $capacity = $basket->takhfif->capacity + $basket->count - $count;

        if ($capacity<0)
            return response()->json(['success' => false
                , 'error' => 'مشکلی پیش آمده صفحه را رفرش(بارگزاری مجدد) کنید '], 200);

        $basket->update([
            'count' => $count,
        ]);

        $basket->takhfif()->update(['capacity' => $capacity]);

        return response()->json(['success' => true ,$count, $capacity  ],200);

    }

    public function destroy(Basket $basket, Request $request)
    {
        //بازگرداندن محصول به انبار
        $basket->product ?
            $basket->product->increment('qty', $basket->count)
            : $basket->package->increment('count', $basket->count);
//        حذف سبد
        $basket->delete();
        if (Auth::user()->baskets()->count() == 0)
            return response()->json(['redirect' => route('home')]);

        list($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount, $basketScore) = BasketHelpers::calcPrices();

//        if ($request->ajax())
        return response()->json([
            'success' => true, 'totalPrice' => $totalPrice, 'total_count' => $total_count,
            'basketScore' => $basketScore, 'totalPrice_no_dis' => $totalPrice_no_dis,
            'total_discount' => $total_discount
            , 'view' => view('user.partials.basket',
                compact(['baskets']))->render(),
            'cart' => view('user.partials.cart')->render()], 200);

    }


    public function checkout()
    {
        list($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount) = BasketHelpers::calcPrices();


        return view('front.checkout',
            compact('baskets', 'totalPrice', 'total_count', 'totalPrice_no_dis', 'total_discount'));
    }

}
