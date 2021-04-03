<?php

namespace App\Http\Shop\Controllers;
use App\Http\Controllers\Controller;

use App\Http\Shop\Models\Takhfif;
use App\Http\Shop\Models\UsageTerm;
use App\Support\JsonResponse;
use Illuminate\Http\Request;

class UsageTermController extends Controller
{
    public function __construct()
    {
        //todo check auth

    }

    public function index(Takhfif $takhfif)
    {
        $terms = UsageTerm::where('takhfif_id', $takhfif)->get();
        return response()->json(['terms' => $terms], 200);
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

        $addTerm = $takhfif->terms()->create($request->all());


        return JsonResponse::sendJsonResponse(1, 'موفق', 'ویژگی با موفقیت ثبت گردید',
            'DATATABLE_REFRESH', '',
            'addTerm', [$addTerm->id, $addTerm->value,
            ]);

    }


    public function destroy(UsageTerm $usage_term)
    {
//        if (!Auth::user()->can('delete-parameter')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $usage_term->delete();

        return response()->json(['data' => ['success' => true, 'message' => 'با موفقیت حذف شد']]);


    }
}
