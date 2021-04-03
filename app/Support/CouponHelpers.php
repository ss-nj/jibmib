<?php

namespace App\Support;

use App\Http\Commerce\Models\Coupon;
use App\Http\Core\Models\Setting;
use Carbon\Carbon;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CouponHelpers
{


    public static function calc($code, $bill = null)
    {
        $currency_unit = Setting::where('key', 'currency_unit')->first()->value_fa;

        $coupon_discount = 0;
        $data['coupon_discount'] = null;

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) {
            $data['message'] = ' خطا کد تخفیف نا معتبر است .';
            $data['status'] = 420;

            return $data;
        }

        // check count and start and end time of coupon
//dd($coupon,Carbon::now() , $coupon->end_time);
        if (Carbon::now() < $coupon->start_time) {
            $data['message'] = ' زمان استفاده از این کد تخفیف فرا نرسیده .';
            $data['status'] = 420;
            return $data;
        }

        if (Carbon::now() > $coupon->end_time) {
            $data['message'] = ' زمان استفاده از این کد تخفیف پایان یافته .';
            $data['status'] = 420;
            return $data;
        }

        if ($coupon->active == 0) {
            $message = 'کد تخفیف غیر فعال است .';
            $data['status'] = 420;
            $data['message'] = $message;
            return $data;
        }

        //check count
        $count = DB::table('coupon_user')
            ->where('coupon_id', $coupon->id)
            ->count();
        if ($coupon->count && $coupon->count != 0 && $count >= $coupon->count) {
            $message = 'متاسفانه ظرفیت استفاده از کد تخفیف تمام شده است .';
            $data['status'] = 420;
            $data['message'] = $message;
            return $data;
        }

        $hasrelation = DB::table('coupon_user')
                ->where('user_id', Auth::user()->id)
                ->where('coupon_id', $coupon->id)
                ->count() > 0;

        if ($hasrelation) {
            $message = 'شما قبلا از این کد تخفیف استفاده کرده اید .';
            $data['status'] = 420;
            $data['message'] = $message;
            return $data;
        }

        $i = 0;
        $total_discount = 0;
        $total_sum = 0;
        $total_sum_no_dis = 0;
        if (!$bill)
            $baskets = Auth::user()->baskets;
        else
            $baskets = $bill->items;

        foreach ($baskets as $basket) {
            $product = $basket->parameter??$basket->product;
            if ($basket->package_id) {
                $package = $basket->package;
                $total_sum += $package->discount * $basket->count;
                $total_sum_no_dis += $package->price1 * $basket->count;
                $total_discount += abs($package->price1 - $package->discount) * $basket->count;
                $i++;
                continue;
            }

            if ($product->discount_price != 0) {
                $discountPrice = ($product->sell_price - (($product->sell_price * $product->discount_price) / 100));
                $price = $discountPrice;
            } else {
                $price = $product->sell_price;
            }

            $total_sum += $price * $basket->count;
            $total_sum_no_dis += $product->sell_price * $basket->count;
            if ($product->discount_price != 0)
                $total_discount += (($product->sell_price * $product->discount_price) / 100) * $basket->count;
            $i++;
        }

        // calc discount amount
        if ($total_sum < $coupon->limit_on_cart) {
            $data['message'] = ' حداقل مقدار سبد خرید جهت استفاده از این کد تخفیف  .' . ($coupon->limit_on_cart / $currency_unit) . ' تومان می باشد ';
            $data['status'] = 420;

            return $data;
        }

        $coupon_discount = self::calcDiscount($coupon, $total_sum) / $currency_unit;

        $message = sprintf('میزان تخفیف کد %s به میزان %s تومان می باشد', $coupon->name, $coupon_discount);

        $data['id'] = $coupon->id;
        $data['name'] = $coupon->name;
        $data['total_sum_no_dis'] = $total_sum_no_dis / $currency_unit;
        $data['total_price'] = $total_sum / $currency_unit;
        $data['total_discount'] = $total_discount / $currency_unit;
         $data['status'] = 200;
        $data['coupon_discount'] = $coupon_discount;
        $data['message'] = $message;
        return $data;

    }

    /**
     * @param $coupon
     * @param $final_sum
     * @return float|int
     */
    private static function calcDiscount($coupon, $total_sum)
    {

        if ($coupon->amount) {
            return min($coupon->amount, $total_sum);
        }

        $discount = (($coupon->percent * $total_sum) / 100);
        if ($coupon->limit_on_discount && $discount > $coupon->limit_on_discount) {
            return min($discount, $coupon->limit_on_discount);
        }

        return $discount;

    }
}
