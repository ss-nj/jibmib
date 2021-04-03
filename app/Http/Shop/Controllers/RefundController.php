<?php

namespace App\Http\Shop\Controllers;

use App\DataTables\RefundDataTable;
use App\Http\Shop\Models\Refund;
use App\Http\Controllers\Controller;

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

//dd($query->get());
        $datatable = new RefundDataTable($query);

        return $datatable->render('panel.refund.index');
    }


    public function store(Request $request)
    {
        //        if (!Auth::user()->can('read-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'shop_id' => ['required', 'integer', 'exists:shops,id'],
            'amount' => ['nullable', 'integer'],
//            'bank_id' => ['nullable', 'integer'],
            'description' => 'integer',
//            'approve_date' => 'integer',
//            'pay_date' => 'integer',
        ]);

        $refund = Refund::create([
            'shop_id'=>$request->shop_id,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ]);

        $refund->bank_id = '';
        $refund->save;

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('درخوست برداشت  %s  با موفقیت ایجاد گردید', $refund->name),
            'DATATABLE_REFRESH');

    }


    public function update(Request $request, Refund $refund)
    {
//        if (!Auth::user()->can('update-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
//            'shop_id' => ['nullable', 'integer', 'exists:shops,id'],
            'amount' => ['nullable', 'integer'],
//            'bank_id' => ['nullable', 'integer'],
            'description' => 'integer',
//            'approve_date' => 'integer',
//            'pay_date' => 'integer',
        ]);

//        $refund = Refund::update([
//            ''=>1,
//            'amount'=>$request->amount,
//            'description'=>$request->description,
//        ]);


        return JsonResponse::sendJsonResponse(1, 'موفق', 'درخوست برداشت با موفقیت روز رسانی گردید',
            'DATATABLE_REFRESH');

    }
}
