<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\TransactionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{

    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $query = Transaction::with('user', 'orders.takhfif.shop');

        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByUserNmae) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->searchByUserNmae . '%')
                    ->orWhere('last_name', 'like', '%' . $request->searchByUserNmae . '%')
                    ->orWhere('mobile', 'like', '%' . $request->searchByUserNmae . '%');
            });
        }

        if ($request->searchByAmount) {
            $query->where('amount', '>=', $request->searchByAmount);
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


        $datatable = new TransactionsDataTable($query);

        return $datatable->render('panel.transaction.index');
    }

}
