<?php

namespace App\Http\Shop\Controllers;

use App\DataTables\ShopTransactionsDataTable;
use App\Http\Commerce\Models\Coupon;
use App\Http\Controllers\Controller;

use App\OrderItem;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    public function index(Request $request)
    {

        $id = auth()->id();
        $query = OrderItem::with('transaction','takhfif')->whereHas('takhfif',function ($query) use($id){
            $query->where('shop_id', $id);
        });

//dd($query->get());
        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
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
}
