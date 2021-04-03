<?php

namespace App\Http\Controllers;


use App\Basket;
use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Takhfif;
use App\Support\BasketHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $request->validate([
            'count' => 'required|numeric',
            'id' => 'exists:takhfifs,id',
        ]);

        $id = $request->id;
        $count = $request->count ?? 1;

        if ($count <= 0) {
            $error = 'تعداد را به طور صحیح وارد کنید';
            return response()->json(['success' => false
                , 'error' => $error], 200);
        }

        $takhfif = Takhfif::findOrFail($id);
        $image = $takhfif->images()->count() ? $takhfif->images()->first()->path : Image::NO_IMAGE_PATH;

        $discount_price = $takhfif->discount_price;

        $price = $takhfif->price;


        if (Auth::check()) {
//            dd(1);
            $basket = Basket::where('takhfif_id', $id)->where('user_id', auth()->id())->first();

            if (!$basket) {
//                dd(1);
                if ($count > $takhfif->capacity) {
                    $error = sprintf('موجودی تنها  %s میباشد ', $takhfif->capacity);
                    return response()->json(['success' => false
                        , 'error' => $error], 200);
                }
                $basket=   Auth::user()->baskets()->create([
                    'user_id' => Auth::id(),
                    'takhfif_id' => $id,
                    'count' => $count,
                    'price' => $price,
                    'discount_price' => $discount_price,
                ]);
                $basket->takhfif()->decrement('capacity', $count);

            } else {
                if ($count > ($takhfif->capacity + $basket->count)) {
                    $error = sprintf('موجودی تنها  %s میباشد ', $takhfif->capacity);
                    return response()->json(['success' => false
                        , 'error' => $error], 200);
                }
                $basket->update([
                    'count' => $count
                ]);
                $basket->takhfif()->increment('capacity', $basket->count);
                $basket->takhfif()->decrement('capacity', $count);
            }


            if ($request->ajax()) return response()->json(['success' => true
                , 'view' => view('front.layouts.cart')->render()], 200);
        }

        $cart = Session::get('cart');

        // if cart is empty then this the first product
        if (!$cart) {

            if ($count > $takhfif->capacity) {
                $error = sprintf('موجودی تنها  %s میباشد ', $takhfif->capacity);
                return response()->json(['success' => false
                    , 'error' => $error], 200);
            }

            $cart = [
                $id => [
                    "name" => $takhfif->name,
                    "count" => $count,
                    "price" => $price,
                    "discount_price" => $discount_price,
                    "image" => $image,
                    "id" => $id,
                    "slug" => $takhfif->slug,

                ]
            ];

            session()->put('cart', $cart);
            session()->save();

            if ($request->ajax()) return response()->json(['success' => true, 'cart' => $cart
                , 'view' => view('front.layouts.cart')->render()], 200);

        }

        if (isset($cart[$id])) {

            if ($count > ($takhfif->capacity + $cart[$id]['count'])) {
                $error = sprintf('موجودی تنها  %s میباشد ', $takhfif->capacity);
                return response()->json(['success' => false
                    , 'error' => $error], 200);
            }
            $cart[$id]['count'] = $count;

        } else {

            $cart[$id] = [
                "name" => $takhfif->name,
                "count" => $count,
                "price" => $price,
                "discount_price" => $discount_price,
                "image" => $image,
                "id" => $id,
                "slug" => $takhfif->slug,

            ];
        }
        session()->put('cart', $cart);
        session()->save();

        if ($request->ajax()) return response()->json(['success' => true, 'cart' => $cart
            , 'view' => view('front.layouts.cart')->render()], 200);

    }

    public function refreshCart(Request $request)
    {

        if (Auth::check()) {
            list($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount) = BasketHelpers::calcPrices();

            return response()->json(['success' => true
                , 'view'   => view( 'front.layouts.cart')->render()
                , 'basket' => view( 'front.layouts.basket')->render()
                ,'total_discount'=>$total_discount,'totalPrice_no_dis'=>$totalPrice_no_dis,'totalPrice'=>$totalPrice
            ], 200);
        }


        $cart = Session::get('cart');

        // if cart is empty then this the first product
        if (!$cart) {

            session()->put('cart', []);
            session()->save();

            return response()->json(['success' => true, 'cart' => []
                , 'view' => view('front.layouts.cart')->render()], 200);
        }


        return response()->json(['success' => true, 'cart' => $cart
            , 'view' => view( 'front.layouts.cart')->render()], 200);

    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:takhfifs,id',
        ]);

        $id = $request->id;

        if (Auth::check()) {

            $basket = Basket::where('takhfif_id', $id)->where('user_id', auth()->id())->first();

            if (!$basket) {
                response()->json(['success' => false], 404);
            } else {
                $basket->takhfif()->increment('capacity', $basket->count);
                $basket->delete();
            }

            if ($request->ajax()) return response()->json(['success' => true], 200);
        }

        $cart = Session::get('cart');
        // if cart is empty then this the first product
        if (!$cart) {
            response()->json(['success' => false], 404);
        }

        if (isset($cart[$id])) {
            unset($cart[$id]);
        } else {
            response()->json(['success' => false], 404);
        }
//        dd($cart,$request->all());

        session()->put('cart', $cart);
        session()->save();

        if ($request->ajax()) return response()->json(['success' => true, 'cart' => $cart], 200);
        return redirect()->back();
    }

}
