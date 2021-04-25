<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\RefundDataTable;
use App\Http\Shop\Models\Refund;
use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        if ($request->searchByName) {
            $query->whereHas('shop', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchByName . '%');
            });
        }

        if ($request->searchByOwner) {
            $query->whereHas('shop', function ($query) use ($request) {
                $query->where('owner_name', 'LIKE', '%' . $request->searchByOwner . '%')->orWhere('phone', 'LIKE', '%' . $request->searchByOwner . '%');
            });
        }

        if (isset($request->searchByStatus)) {
            $query->where('active', $request->searchByStatus);

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

        $shops = Shop::all();
//dd($query->get());
        $datatable = new RefundDataTable($query);

        return $datatable->render('panel.refund.index', compact('shops'));
    }


    public function store(Request $request)
    {
        //        if (!Auth::user()->can('read-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'shop_id' => ['required', 'integer', 'exists:shops,id'],
            'amount' => ['required', 'integer'],
            'bank_id' => ['required'],
            'description' => 'nullable', 'max:500',
//            'approve_date' => 'integer',
//            'pay_date' => 'integer',
        ]);

        $shop = Shop::findOrFail($request->shop_id);

        $refund = $shop->refunds()->create([
            'amount' => $request->amount,
            'bank_id' => $request->bank_id,
            'description' => $request->description,
        ]);
//        dd(1);

        $refund->by_admin = 1;
        $refund->save;
        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('درخواست برداشت  %s  با موفقیت ایجاد گردید', $refund->name),
            'DATATABLE_REFRESH');

    }


    public function update(Request $request, Refund $refund)
    {
//        if (!Auth::user()->can('update-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'amount' => ['required', 'integer'],
            'bank_id' => ['required'],
            'description' => 'nullable', 'max:500',
//            'approve_date' => 'integer',
//            'pay_date' => 'integer',
        ]);

        $refund->update($request->all());


        return JsonResponse::sendJsonResponse(1, 'موفق', 'درخوست برداشت با موفقیت روز رسانی گردید',
            'DATATABLE_REFRESH');

    }

    public function ajaxEdit(Refund $refund)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }


        return view('panel.refund.refund-edit', compact('refund'))->render();
    }
}
