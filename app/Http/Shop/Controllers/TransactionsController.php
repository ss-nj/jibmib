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

        $transactions = [];

//        dd($transactions);
        return view('shop.transactions.index', compact('transactions'));

    }
}
