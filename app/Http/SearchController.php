<?php

namespace App\Http;

use App\Http\Commerce\Models\Place;
use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Takhfif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    function action($city, Request $request)
    {
        $city = $this->getCity($city);

        $search = $request->q;
        $title = sprintf('جستجوی  : %s', $search);
        $canonical = route('search.action',$city);


        $takhfifs = Takhfif::
        with('images', 'categories')
            ->whereHas('shop', function ($query) use ($city) {
                $query->where('place_id', $city->id);
            })
            ->where('name', 'LIKE', '%' . $search . '%')
            ->get();


        return view('front.search', compact('canonical', 'title', 'takhfifs'));

    }


    public function ajaxSearch($city, Request $request)
    {

        $city = $this->getCity($city);

        $search = $request->q;
        $takhfifs = [];

        if ($search !== "") {
            $takhfifs = Takhfif::
            with('images', 'categories')->
            whereHas('shop', function ($query) use ($city) {
                $query->where('place_id', $city->id);
            });

            $takhfifs = $takhfifs
//                ->where('active', 1)
                ->where('name', 'LIKE', '%' . $search . '%')
                ->limit(15)
                ->select("name")
                ->orderBy('updated_at', 'DESC')
                ->get();
//            dd($takhfifs);


        }

        return response()->json($takhfifs);

    }

    /**
     * @param $city
     * @return mixed
     */
    public function getCity($city)
    {
        $city = Place::where('slug', $city)->firstOrfail();
        Session::put('selected_city', $city->slug);
        return $city;
    }
}
