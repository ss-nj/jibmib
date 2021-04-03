<?php


namespace App\Support;


use App\Basket;
use App\Http\Shop\Models\Takhfif;
use Illuminate\Support\Facades\Auth;

class BasketHelpers
{
    public static function setSessionCartToDatabase()
    {
        $flag = false;
        foreach (session('cart',[]) as $cart) {
            //find if its in basket basket
            $basket = Basket::where('takhfif_id', $cart['id'])->where('user_id', auth()->id())->first();
            $takhfif = Takhfif::find($cart['id']);

            if (!$basket) {
                if ($cart['count'] > $takhfif->capacity) {
                    $flag = true;
                    continue;
                }
                Auth::user()->baskets()->create([
                    'takhfif_id' => $cart['id'],
                    'count' => $cart['count'],
                    'price' => $cart['price'],
                    'discount_price' => $cart['discount_price'],
                ]);
                $takhfif->decrement('capacity', $cart['count']);

            } else {
                //check remaining capacity
                if ($cart['count'] > $basket->takhfif->capacity) {
                    $flag = true;
                    continue;
                }
                $basket->increment('count', $cart['count']);
                $basket->takhfif()->increment('capacity', $basket->count);
                $basket->takhfif()->decrement('capacity', $cart['count']);
            }
        }
        return $flag;
    }

    public static function calcPrices(): array
    {

        $baskets = Basket::where('user_id', auth()->id())->with('takhfif')->get();

        $totalPrice = 0;
        $totalPrice_no_dis = 0;
        $total_count = 0;
        foreach ($baskets as $b) {
            $total_count += $b->count;
            $totalPrice += $b->discount_price * $b->count;
            $totalPrice_no_dis += $b->price * $b->count;

        }
        $total_discount = $totalPrice_no_dis - $totalPrice;

        return array($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount);
    }

}
