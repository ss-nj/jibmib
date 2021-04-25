<?php

namespace App\Http\Shop\Controllers;

use App\DataTables\ShopTransactionsDataTable;
use App\Http\Commerce\Models\Coupon;
use App\Http\Controllers\Controller;

use App\OrderItem;
use App\Support\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    public function index(Request $request)
    {

        $id = auth()->id();
        $query = OrderItem::with('transaction', 'takhfif')->whereHas('takhfif', function ($query) use ($id) {
            $query->where('shop_id', $id);
        });

//dd($query->get());
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
            $query->where('approved', $request->searchByStatus);
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

        if (!$coupon)
            return JsonResponse::sendJsonResponse(1, 'خطا', 'کد وارد شده نامعتبر است',);

        if ($coupon->status)
            return JsonResponse::sendJsonResponse(0, 'خطا',
                sprintf('کد وارد شده" %s " قبلا  در تاریخ  %s باطل شده است',$code,$coupon->revoke_date));

        $coupon->status = 1;
        $coupon->save();
    }
}
