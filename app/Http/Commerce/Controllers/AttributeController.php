<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\AttributesDataTable;
use App\Http\Commerce\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $query = Attribute::query();


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
        $datatable = new AttributesDataTable($query);
//dd(1);
        return $datatable->render('panel.attributes.index');
    }

    public function store(Request $request)
    {
//        dd($request->all());
//        if (!Auth::user()->can('read-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'title' => 'required|string|min:2|max:100',
            'multiple' => ['nullable','integer','in:1,2'],
            'description' => ['nullable', 'string', 'max:99999'],
            'position' => ['nullable','integer'],
            'active' =>['nullable', 'integer'],
            'field_type' => ['required','string','required','in:'.implode(',',array_keys(Attribute::TYPE_MAP))],
            'validation_unit' => ['nullable','string'],
            'validation_length' =>[ 'nullable','integer'],
        ]);


        $attribute = Attribute::create($request->all());

        $attribute->slug = str_slug_persian($request->slug ?? $attribute->name);
        $attribute->save;

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('ویژگی  %s  با موفقیت ایجاد گردید', $attribute->name),
            'DATATABLE_REFRESH');

    }

    public function update(Request $request, Attribute $attribute)
    {
//        if (!Auth::user()->can('update-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'title' => 'required|string|min:2|max:100',
            'multiple' => ['nullable','integer','in:1,2'],
            'description' => ['nullable', 'string', 'max:99999'],
            'position' => ['nullable','integer'],
            'active' =>['nullable', 'integer'],
            'field_type' => ['string','required','in:'.implode(',',array_keys(Attribute::TYPE_MAP))],
            'validation_unit' => ['nullable','string'],
            'validation_length' =>[ 'nullable','integer'],
        ]);

        $attribute->update($request->all());

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('ویژگی  %s  با موفقیت روز رسانی گردید', $attribute->name),
            'DATATABLE_REFRESH');

    }

    public function destroy(Attribute $attribute)
    {
//        if (!Auth::user()->can('delete-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        //check if has product or items

        $item_count = $attribute->values->count();
        if ($item_count)
            return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('ویژگی  %s  با موفقیت روز رسانی گردید', $attribute->name),
                'REDIRECT', route('attribute.index'));


        $attribute->delete();

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('ویژگی  %s  با موفقیت روز رسانی گردید', $attribute->name),
            'REDIRECT', route('attribute.index'));

    }


    public function activeToggle(Request $request, Attribute $attribute)
    {
//        dd($attribute);
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $attribute->active = !$attribute->active;
        $attribute->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $attribute->active]);

        return back();
    }

    public function ajaxEdit(Attribute $attribute)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }



        return view('panel.attributes.edit', compact('attribute'))->render();
    }

}
