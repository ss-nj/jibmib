<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Http\Shop\Models\Takhfif;
use App\Http\Shop\Models\Transaction;
use App\OrderItem;
use App\Providers\RouteServiceProvider;
use App\Support\BasketHelpers;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Larabookir\Gateway\Gateway;
use Larabookir\Gateway\Mellat\Mellat;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'count' => ['required', 'digits_between:1,999'],
            'id' => ['required']
        ]);

        $count = $request->count;
        $basket = Basket::with('takhfif')->where('user_id', auth()->id())->find($request->id);
        if (!$basket)
            return response()->json(['success' => false
                , 'error' => 'محصول قبلا از سبد حذف شده صفحه را رفرش(بارگزاری مجدد) کنید '], 200);


        if ($count > ($basket->takhfif->capacity + $basket->count)) {
            $error = sprintf('موجودی تنها  %s میباشد ', $basket->takhfif->capacity);
            return response()->json(['success' => false
                , 'error' => $error], 200);
        }

        $capacity = $basket->takhfif->capacity + $basket->count - $count;

        if ($capacity < 0)
            return response()->json(['success' => false
                , 'error' => 'مشکلی پیش آمده صفحه را رفرش(بارگزاری مجدد) کنید '], 200);

        $basket->update([
            'count' => $count,
        ]);

        $basket->takhfif()->update(['capacity' => $capacity]);

        return response()->json(['success' => true, $count, $capacity], 200);

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

    public function pay()
    {
        list($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount) = BasketHelpers::calcPrices();

        $price = $totalPrice*10;
        return $this->payWithMellat($price);

    }

    /**
     * @param $price
     * @return mixed
     */
    public function payWithMellat($price)
    {

        $gateway = Gateway::make(new Mellat());
        $gateway->setCallback(route('callback')); // You can also change the callback
        $gateway->price($price)
            ->ready();

        $refId = $gateway->refId(); // شماره ارجاع بانک
        $transID = $gateway->transactionId(); // شماره تراکنش


        Transaction::create([
            'user_id' => Auth::id(),
            'is_for' => 'cart-pay',
            'amount' => $price,
            'meta' => [
                'call-ip' => request()->getClientIp(),
                'trans-id' => $transID,
                'call-amount' => $price,
                'return-ip' => '',
                'return-amount' => '',
            ],
            'cardNumber' => '',
            'payment_date' => now(),
            'track_code' => '',
            'ref_id' => $refId,
            'status' => 2,
            'ip' => request()->getClientIp(),
        ]);


        return $gateway->redirect();

    }

    public function callback()
    {

        try {

            $gateway = Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();
            $cardNumber = $gateway->cardNumber();

            $transaction = Transaction::where('ref_id', $refId)->firstOrFail();

            $price = $gateway->getPrice()/10;

            $transaction->update([
                'meta' => [
                    'return-ip' => request()->getClientIp(),
                    'return-amount' => $price,
                ],
                'cardNumber' => $cardNumber,
                'payment_date' => now(),
                'track_code' => $trackingCode,
                'ref_id' => $refId,
                'status' => 1,
                'ip' => request()->getClientIp(),
            ]);

//manage cart
            list($baskets, $totalPrice, $totalPrice_no_dis, $total_count, $total_discount) = BasketHelpers::calcPrices($transaction->user_id);

            if ($price != $totalPrice) {
                $message = 'مشکلی در پرداخت پیش آمده لطفا شماره ی پیگیری خود را برای پشتیبانی ارسال کنید . در اولین فرصت مبلغ به حساب شما برگردانده خواهد شد .';
                return view('front.callback', compact('transaction', 'message'));
            }


            //save basket to orders and order items
            foreach ($baskets as $basket) {
//dd($basket);
             $a=   OrderItem::create([
                    'transaction_id' => $transaction->id,
                    'takhfif_id' => $basket->takhfif_id,
                    'user_id' => $basket->user_id,
                    'takhfif_name' => $basket->takhfif->name,
                    'code' => $this->generateCodeLink($basket->user_id),
                    'takhfif_price' => $basket->takhfif->price,
                    'takhfif_discount' => $basket->takhfif->discount_price,
                    'takhfif_count' => $basket->count,
                ]);

            }

            $message = false;
            return view('front.callback', compact('transaction'));

        } catch (\Larabookir\Gateway\Exceptions\RetryException $e) {

            // تراکنش قبلا سمت بانک تاییده شده است و
            // کاربر احتمالا صفحه را مجددا رفرش کرده است
            // لذا تنها فاکتور خرید قبل را مجدد به کاربر نمایش میدهیم


            $message = $e->getMessage();
            return view('front.callback', compact('message'));

        } catch (\Exception $e) {
            // نمایش خطای بانک
            $message = $e->getMessage();
            return view('front.callback', compact('message'));
        }
    }



    private function generateCodeLink($user_id)
    {
        do {
            $code = rand_str(10);
            $status = OrderItem::where('code', $code)->count();
        } while ($status);


        $path = public_path('img/users/'.$user_id.'/coupons/');

        if(!File::isDirectory($path)){

            File::makeDirectory($path, 0777, true, true);
        }

        QrCode::generate(route('home').'/coupons/'.$code, 'img/users/'.$user_id.'/coupons/'.$code.'.svg');

        return $code;


    }
}

