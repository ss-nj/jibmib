<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\PlaceDataTable;
use App\Http\Commerce\Models\Place;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlaceController extends Controller
{

    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $query = Place::query();


        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('name', 'LIKE', '%' . $request->searchByName . '%');
        }
        if ($request->searchBySlug) {
            $query->where('slug', 'LIKE', '%' . $request->searchBySlug . '%');
        }

        if ($request->searchByCity) {
            $query->whereHas('city', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchByCity . '%');
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
            $query->latest('position');

//dd($query->get());
        $datatable = new PlaceDataTable($query);

        return $datatable->render('panel.places.index');
    }


    public function store(Request $request)
    {
//        dd($request->all());
//        if (!Auth::user()->can('read-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'name' => 'required|string|min:2|max:254',
            'slug' => 'required|string|min:2|max:254|unique:places,slug',
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'position' => 'integer',
            'active' => 'integer',
        ]);

        $place = Place::create($request->all());

        $place->slug = $request->slug ? str_slug_persian($request->slug) : Str::slug($place->name, '-');
        $place->save;

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منطقه  %s  با موفقیت ایجاد گردید', $place->name),
            'DATATABLE_REFRESH');

    }


    public function update(Request $request, Place $place)
    {
//        if (!Auth::user()->can('update-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'name' => 'required|string|min:2|max:254',
            'slug' => 'required|string|min:2|max:254|unique:places,slug,' . $place->id,
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'position' => 'integer',
            'active' => 'integer',
        ]);

        $place->update($request->all());

        $place->slug = str_slug_persian($request->slug ?? $place->name);
        $place->save;

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منطقه  %s  با موفقیت روز رسانی گردید', $place->name),
            'DATATABLE_REFRESH');

    }

    public function destroy(Place $place)
    {
//        if (!Auth::user()->can('delete-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        //check if has product or items

        $item_count = $place->items->count();
        if ($item_count)
            return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منطقه  %s  با موفقیت روز رسانی گردید', $place->name),
                'REDIRECT', route('places.index'));


        $place->delete();

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منطقه  %s  با موفقیت روز رسانی گردید', $place->name),
            'REDIRECT', route('places.index'));

    }


    public function activeToggle(Request $request, Place $place)
    {
//        dd($place);
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $place->active = !$place->active;
        $place->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $place->active]);

        return back();
    }

    public function ajaxEdit(Place $place)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }

        $provinces = DB::table('provinces')->get();
        $cities = DB::table('cities')->get();

        return view('panel.places.place-edit', compact('place', 'provinces', 'cities'))->render();
    }

}
