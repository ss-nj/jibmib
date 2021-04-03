<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopDashboardController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $shop;

    public function __construct()
    {
        $this->shop = Auth::user();
    }

    public function index()
    {

        return view('shop.dashboard.dashboard',['shop'=>$this->shop]);
    }
}
