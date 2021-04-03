<?php

namespace App\Http\Core\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    //

    public function cityList()
    {
        $cities = DB::table('cities')->where('province_id', request()->province_id)->get();

        return response()->json(['data' => $cities]);
    }

    public function provinceList()
    {
        $provincies = DB::table('provinces')->get();

        return response()->json(['data' => $provincies]);

    }

    public function placesList()
    {
        $places = DB::table('places')->where('city_id', request()->city_id)->get();

        return response()->json(['data' => $places]);

    }

}
