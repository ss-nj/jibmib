<?php

namespace App\Http\Shop\Controllers;

use App\DataTables\ShopRefundDataTable;
use App\Http\Shop\Models\Refund;
use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{

    public function index(Request $request)
    {

        $query = Refund::where('shop_id', Auth::guard('shop')->id());


        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
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

//dd($query->get());
        $datatable = new ShopRefundDataTable($query);

        return $datatable->render('shop.refund.index');
    }


    public function store(Request $request)
    {

        $shop = Shop::findOrFail(Auth::guard('shop')->id());

        $request->validate([
            'amount' => ['required', 'integer', 'max:' . ($shop->wallet ? $shop->wallet->amount : 0)],
            'bank_id' => ['required'],
            'description' => 'nullable', 'max:500',
        ]);


        $refund = $shop->refunds()->create([
            'amount' => $request->amount,
            'bank_id' => $request->bank_id,
            'description' => $request->description,
        ]);

        $shop->wallet()->decrement('amount', $refund->amount);


        return JsonResponse::sendJsonResponse(1, 'موفق', 'درخوست برداشت با موفقیت روز رسانی گردید',
            'DATATABLE_REFRESH');

    }

    public function ajaxEdit(Refund $refund)
    {
        if ($refund->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);

        return view('shop.refund.edit-refund', compact('refund'))->render();
    }


    public function update(Request $request, Refund $refund)
    {
        if ($refund->shop_id != Auth::guard('shop')->id())
            return JsonResponse::sendJsonResponse(0, 'خطا', 'کد وارد شده متعلق به فروشگاه شما نیست !!',);


        if ($refund->status != 0)
            return JsonResponse::sendJsonResponse(0, 'خطا', 'امکان ویرایش وجود ندارد',
                'DATATABLE_REFRESH');
        $maxAmount = $refund->shop->wallet ? ($refund->shop->wallet->amount + $refund->amount) : 0;
        $request->validate([
            'amount' => ['required', 'integer', 'max:' . $maxAmount],
            'bank_id' => ['required'],
            'description' => 'nullable', 'max:500',
        ]);


        $refund->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'bank_id' => $request->bank_id,
        ]);

        $refund->shop->wallet()->increment('amount', $refund->amount);
        $refund->shop->wallet()->decrement('amount', $request->amount);

        return JsonResponse::sendJsonResponse(1, 'موفق', 'درخوست برداشت با موفقیت روز رسانی گردید',
            'DATATABLE_REFRESH');

    }
}
