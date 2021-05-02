<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\OrdersDataTable;
use App\DataTables\ShopTransactionsDataTable;
use App\Http\Controllers\Controller;
use App\OrderItem;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

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


        $datatable = new OrdersDataTable($query);

//        dd($query->get());
//        return view('shop.coupons.index');
        return $datatable->render('panel.order.index');

    }

}
