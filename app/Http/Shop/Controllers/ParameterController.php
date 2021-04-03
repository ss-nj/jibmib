<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Parameter;
use App\Http\Shop\Models\Takhfif;
use App\Support\JsonResponse;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function __construct()
    {
        //todo check auth

    }

    public function index(Takhfif $takhfif)
    {
        $parameters = Parameter::where('takhfif_id', $takhfif)->get();
        return response()->json(['parameters' => $parameters], 200);
    }

    public function store(Request $request, Takhfif $takhfif)
    {
//        dd($request->all());
//        if (!Auth::user()->can('store-parameter')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'value' => ['required', 'string','max:999'],

        ]);

        $parameter = $takhfif->parameters()->create($request->all());


        return JsonResponse::sendJsonResponse(1, 'موفق', 'ویژگی با موفقیت ثبت گردید',
            'DATATABLE_REFRESH', '',
            'addParameter', [$parameter->id, $parameter->value,
            ]);

    }


    public function destroy(Parameter $parameter)
    {
//        if (!Auth::user()->can('delete-parameter')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $parameter->delete();

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }
}
