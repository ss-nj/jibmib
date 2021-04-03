<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->transactions()->orderBy('created_at', 'desc')->get();

        return view('transactions.index', compact('transactions'));
    }
}
