<?php

namespace App\Http\Shop\Controllers;

use App\DataTables\ShopRefundDataTable;
use App\Http\Shop\Models\Refund;
use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;

class RefundController extends Controller
{

    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $query = Refund::query();


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
        //        if (!Auth::user()->can('read-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $shop = Shop::findOrFail(1);

        $request->validate([
            'amount' => ['required', 'integer','max:'.($shop->wallet?$shop->wallet->amount:0)],
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
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }


        return view('shop.refund.edit-refund', compact('refund'))->render();
    }


    public function update(Request $request, Refund $refund)
    {
//        if (!Auth::user()->can('update-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        if ($refund->status != 0)
            return JsonResponse::sendJsonResponse(1, 'موفق', 'امکان ویرایش وجود ندارد',
                'DATATABLE_REFRESH');
        $maxAmount = $refund->shop->wallet ? ($refund->shop->wallet->amount+$refund->amount) : 0;
        $request->validate([
            'amount' => ['required', 'integer','max:'.$maxAmount],
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
