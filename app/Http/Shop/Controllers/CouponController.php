<?php

namespace App\Http\Shop\Controllers;

use App\DataTables\ShopTransactionsDataTable;
use App\Http\Controllers\Controller;
use App\OrderItem;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    //
    public function index(Request $request)
    {

        $id = Auth::guard('shop')->id();

        $query = OrderItem::with('transaction', 'takhfif')->whereHas('takhfif', function ($query) use ($id) {
            $query->where('shop_id', $id);
        });

        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('takhfif_name', 'LIKE', '%' . $request->searchByName . '%');
        }

        if ($request->searchByUserName) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->searchByUserName . '%')
                    ->orWhere('last_name', 'like', '%' . $request->searchByUserName . '%')
                    ->orWhere('mobile', 'like', '%' . $request->searchByUserName . '%');
            });
        }


        if (isset($request->searchByStatus)) {
            $query->where('status', $request->searchByStatus);
        }

        if ($request->searchByAscDesc) {
            $ascDesc = $request->searchByAscDesc;

        } else {
            $ascDesc = 'DESC';
        }

        if ($request->searchSortBy) {
            $searchSortBy = $request->searchSortBy;
            if ($ascDesc == 'DESC')
                $query->latest($searchSortBy);
            else
                $query->oldest($searchSortBy);

        } else
            $query->latest('created_at');


        $datatable = new ShopTransactionsDataTable($query);

//        dd($query->get());
//        return view('shop.coupons.index');
        return $datatable->render('shop.coupons.index');

    }

    public function revoke(Request $request)
    {

        $request->validate([
            'code' => ['required', 'exists:order_items,code'],
        ]);

        $code = $request->code;

        $coupon = OrderItem::where('code', $code)->first();

        if ($coupon->takhfif->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        if (!$coupon)
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده نامعتبر است',);

        if ($coupon->status)
            return JsonResponse::sendJsonResponse(0, 'خطا',
                sprintf('کد وارد شده" %s " قبلا  در تاریخ  "%s" باطل شده است',
                    $code, verta($coupon->$coupon)->timezone('Asia/Tehran')->format('Y/m/d H:i')));

        $coupon->status = 1;
        $coupon->revoke_date = now();
        $coupon->save();

        return JsonResponse::sendJsonResponse(1, 'موفق',
            sprintf('کوپن به کد "%s" مربوط به خریدار "%s" و تخفیف "%s" باطل شد', $code, $coupon->user->full_name, $coupon->takhfif_name));
    }
}
