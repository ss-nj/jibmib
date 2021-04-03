<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\CouponsDataTable;
use App\DataTables\PlaceDataTable;
use App\Http\Commerce\Models\Coupon;
use App\Http\Commerce\Models\Place;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //
    public function index(Request $request)
    {
//        if (!Auth::user()->can('read-coupon')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }


        $query = Coupon::query();


        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('name', 'LIKE', '%' . $request->searchByName . '%');
        }
        if ($request->searchByCode) {
            $query->where('code', 'LIKE', '%' . $request->searchBySlug . '%');
        }

        if ($request->searchByCity) {
            $query->whereHas('city', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchByCity . '%');
            });
        }
        if (isset($request->searchByType)) {
            $query->where('type', $request->searchByType);

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
            $query->latest('created_at');

//dd($query->get());
        $datatable = new CouponsDataTable($query);

        return $datatable->render('panel.coupons.index');
    }

    public function create()
    {
        return view('panel.coupons.create');
    }

    public function store(Request $request)
    {
//dd($request->all());
//        if (!Auth::user()->can('create-coupon')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:254'],
            'description' => 'nullable|string',
            'takhfifs.*' => 'nullable|exists:takhfifs,id',
            'code' => ['required', 'string', 'min:4', 'alpha_num', 'max:254', 'unique:coupons'],
            'limit_on_discount' => ['nullable', 'integer'],
            'limit_on_cart' => ['nullable', 'integer'],
            'percent' => ['nullable', 'integer'],
            'count' => ['nullable', 'integer'],
            'amount' => ['nullable', 'integer'],
            'start_time' => ['required'],
            'expire_time' => ['required'],
            'type' => ['required', 'boolean'],
            'effect_zone' => ['required', 'boolean']
        ]);

        list($start_time, $expire_time) = $this->saveTimes($request);


//dd($start_time,$expire_time);
        $request->merge([
            'start_time' => $start_time,
            'expire_time' => $expire_time,
        ]);

        $coupon = Coupon::create($request->all());

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('کوپن  %s  با موفقیت روز رسانی گردید', $coupon->name),
            'REDIRECT', route('coupons.index'));
    }

    public function update(Request $request, Coupon $coupon)
    {
//        if (!Auth::user()->can('update-coupon')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:254'],
            'description' => 'nullable|string',
            'products.*' => 'nullable|exists:products,id',
            'code' => ['required', 'string', 'min:4', 'max:254', 'alpha_num', 'unique:coupons,code,' . $coupon->id],
            'limit_on_discount' => ['nullable', 'integer'],
            'limit_on_cart' => ['nullable', 'integer'],
            'percent' => ['nullable', 'integer'],
            'amount' => ['nullable', 'integer'],
            'start_time' => ['required'],
            'expire_time' => ['required'],
            'type' => ['required', 'boolean'],
            'effect_zone' => ['required', 'boolean']
        ]);

        list($start_time, $expire_time) = $this->saveTimes($request);

        $request->merge([
            'start_time' => $start_time,
            'expire_time' => $expire_time,
        ]);
        $coupon->update($request->all());

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('کوپن  %s  با موفقیت روز رسانی گردید', $coupon->name),
            'REDIRECT', route('coupons.index'));
    }

    public function activeToggle(Request $request, Coupon $coupon)
    {

//        if (!Auth::user()->can('delete-coupon')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $coupon->active = !$coupon->active;
        $coupon->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $coupon->active]);
        return back();
    }

    /**
     * @param Request $request
     * @return string[]
     */
    public function saveTimes(Request $request): array
    {
        $start_time = explode('-', fa_to_en($request->start_time));
        $time = $start_time[3];
        $start_time = Verta::getGregorian($start_time[0], $start_time[1], $start_time[2]);
        $start_time = implode('-', $start_time) . ' ' . $time;

        $expire_time = explode('-', fa_to_en($request->expire_time));
        $time = $expire_time[3];
        $expire_time = Verta::getGregorian($expire_time[0], $expire_time[1], $expire_time[2]);
        $expire_time = implode('-', $expire_time) . ' ' . $time;
        return array($start_time, $expire_time);
    }

    public function edit( Coupon $coupon)
    {
        return view('panel.coupons.edit',compact('coupon'));
    }


}
