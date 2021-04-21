<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Transaction;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index()
    {
        $id = auth()->id();

        $transactions = Transaction::with('user')->whereHas('orders',function ($query)use ($id) {
            $query->whereHas('takhfif', function ($query) use ($id) {
                $query->where('shop_id', $id);
            });
        })->withCount('orders')->get();

//        dd($transactions);
        return view('shop.transactions.index', compact('transactions'));

    }
}
