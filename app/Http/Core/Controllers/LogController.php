<?php

namespace App\Http\Core\Controllers;

use App\DataTables\LogsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\ModelLog;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(Request $request)
    {
//        dd(Supplier::find(1)->is_in_time);
//        if (!Auth::user()->can('read-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $start_time = null;
        $end_time = null;
        if ($request->searchByStartTime !== null && $request->has('searchByStartTime')) {
            $start_time = fa_to_en($request->searchByStartTime);
            $start_time = explode('-', $start_time);
            $time = $start_time[3];
            $start_time = Verta::getGregorian($start_time[0], $start_time[1], $start_time[2]);
            $start_time = implode('-', $start_time);
            $start_time = $start_time . ' ' . $time;

        }

        if ($request->searchByEndTime !== null && $request->has('searchByEndTime')) {
            $end_time = fa_to_en($request->searchByEndTime);
            $end_time = explode('-', $end_time);
            $time = $end_time[3];
            $end_time = Verta::getGregorian($end_time[0], $end_time[1], $end_time[2]);
            $end_time = implode('-', $end_time);
            $end_time = $end_time . ' ' . $time;

        }

        $modelTypeMap = [
            'user' => 'App\Http\Core\Models\User',
            'city_price' => 'App\Http\Commerce\Models\CityPrice',
            'setting' => 'App\Http\Core\Models\Setting',
            'menu' => 'App\Http\Core\Models\Menu',
        ];

        $query = ModelLog::query();

//UserId UserName UserMobile ModelTYpe old_values
//new_values
        if ($request->searchByUserId) {
            $query->where('user_id', 'LIKE', '%' . $request->searchById . '%');
        }
       if ($request->searchByModelId) {
            $query->where('auditable_id',  $request->searchByModelId );
        }
        if ($request->searchByModelType) {
            $query->where('auditable_type', $modelTypeMap[$request->searchByModelType]);
        }

       if ($start_time) {
            $query->where('created_at','>=', $start_time);
        }

       if ($end_time) {
            $query->where('created_at','<=', $end_time);
        }

        if ($request->searchByModelEvent) {
            $query->where('event', $request->searchByModelEvent);
        }

        if ($request->searchByUserName) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->searchByUserName . '%')
                    ->orWhere('last_name', 'like', '%' . $request->searchByUserName . '%')
                    ->orWhere('mobile', 'like', '%' . $request->searchByUserName . '%');
            });
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
        $datatable = new LogsDataTable($query);

        return $datatable->render('panel.logs.index');
    }

    public function show($log)
    {
//        if (!Auth::user()->can('read-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//dd($user,$user->address);


        return view('panel.users.show', compact('user', 'provinces', 'cities'));

    }
}
